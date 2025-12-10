#!/bin/bash

# 🚀 Script de Inicialização Rápida - Melhores do Ano
# Autor: @LuizKirsch

echo "🏆 Iniciando Melhores do Ano..."
echo ""

# Verificar se Docker está rodando
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker não está rodando. Por favor, inicie o Docker primeiro."
    exit 1
fi

# Verificar se .env existe
if [ ! -f .env ]; then
    echo "📝 Criando arquivo .env..."
    cp .env.example .env
    echo "⚠️  IMPORTANTE: Configure seu NGROK_AUTHTOKEN no arquivo .env"
    echo "   Obtenha em: https://dashboard.ngrok.com/get-started/your-authtoken"
    echo ""
    read -p "Pressione ENTER após configurar o token..."
fi

# Verificar se token ngrok está configurado
if ! grep -q "NGROK_AUTHTOKEN=.*[a-zA-Z0-9]" .env; then
    echo "⚠️  Token ngrok não encontrado no .env"
    echo "   Adicione: NGROK_AUTHTOKEN=seu_token_aqui"
    echo "   Obtenha em: https://dashboard.ngrok.com/get-started/your-authtoken"
    exit 1
fi

# Subir containers
echo "🐳 Subindo containers..."
docker compose up -d

# Aguardar containers iniciarem
echo "⏳ Aguardando containers iniciarem..."
sleep 10

# Verificar se app está rodando
if ! docker compose ps app | grep -q "Up"; then
    echo "❌ Container da aplicação falhou ao iniciar"
    docker logs app
    exit 1
fi

# Build dos assets
echo "🎨 Compilando assets..."
docker exec -it app npm run build > /dev/null 2>&1

# Limpar caches
echo "🧹 Limpando caches..."
docker exec -it app php artisan optimize:clear > /dev/null 2>&1

# Obter URL pública
echo "🌐 Obtendo URL pública..."
sleep 5

PUBLIC_URL=$(curl -s http://localhost:4040/api/tunnels 2>/dev/null | grep -o '"public_url":"[^"]*"' | head -1 | cut -d'"' -f4)

if [ -n "$PUBLIC_URL" ]; then
    echo ""
    echo "🎉 APLICAÇÃO ESTÁ ONLINE!"
    echo "🔗 URL Pública: $PUBLIC_URL"
    echo "📊 Painel ngrok: http://localhost:4040"
    echo "🗄️  phpMyAdmin: http://localhost:8081"
    echo ""
    echo "🚀 Para rebuild dos assets: docker exec -it app npm run build"
    echo "🛑 Para parar: docker compose down"
else
    echo "⚠️  Não foi possível obter URL pública. Verifique:"
    echo "   - Token ngrok no .env"
    echo "   - Logs: docker logs ngrok"
fi

echo ""
echo "✅ Setup concluído!"

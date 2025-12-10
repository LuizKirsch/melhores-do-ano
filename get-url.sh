#!/bin/bash

# 🔗 Script para obter URL pública rapidamente
# Autor: @LuizKirsch

echo "🌐 Obtendo URL pública..."

# Verificar se ngrok está rodando
if ! docker compose ps ngrok | grep -q "Up"; then
    echo "❌ Container ngrok não está rodando"
    echo "   Execute: docker compose up -d"
    exit 1
fi

# Obter URL
PUBLIC_URL=$(curl -s http://localhost:4040/api/tunnels 2>/dev/null | grep -o '"public_url":"[^"]*"' | head -1 | cut -d'"' -f4)

if [ -n "$PUBLIC_URL" ]; then
    echo ""
    echo "🎉 URL PÚBLICA ATIVA:"
    echo "🔗 $PUBLIC_URL"
    echo ""
    echo "📋 Copie e cole onde precisar!"

    # Tentar copiar para clipboard (se disponível)
    if command -v xclip &> /dev/null; then
        echo "$PUBLIC_URL" | xclip -selection clipboard
        echo "📋 URL copiada para clipboard!"
    elif command -v pbcopy &> /dev/null; then
        echo "$PUBLIC_URL" | pbcopy
        echo "📋 URL copiada para clipboard!"
    fi
else
    echo "❌ Não foi possível obter URL pública"
    echo "   Verifique os logs: docker logs ngrok"
fi

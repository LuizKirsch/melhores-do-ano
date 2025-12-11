<div class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 relative overflow-hidden">
    <!-- Controles da Apresentação -->
    <div class="absolute top-4 right-4 z-50 flex gap-2">
        @if($totalSlides > 0)
            <button
                wire:click="prevSlide"
                class="px-3 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg backdrop-blur-sm transition-all"
                title="Slide anterior"
            >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <button
                wire:click="nextSlide"
                class="px-3 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg backdrop-blur-sm transition-all"
                title="Próximo slide"
            >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
        @endif

        <a href="{{ route('admin.home') }}"
           class="px-3 py-2 bg-red-500/80 hover:bg-red-600 text-white rounded-lg backdrop-blur-sm transition-all"
           title="Sair da apresentação">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>

    @if($totalSlides > 0)
        <!-- Slide Principal -->
        <div class="flex items-center justify-center min-h-screen p-8">
            <div class="text-center max-w-4xl mx-auto">
                @foreach($alternatives as $index => $alternative)
                    <div class="slide-content {{ $currentSlide === $index ? 'opacity-100 scale-100' : 'opacity-0 scale-95 absolute' }}
                         transition-all duration-700 ease-in-out transform"
                         style="{{ $currentSlide !== $index ? 'pointer-events: none;' : '' }}">

                        <!-- Título da Categoria -->
                        <h1 class="text-6xl font-bold text-white mb-8 animate-fade-in">
                            {{ $alternative['title'] }}
                        </h1>

                        @if(!$showWinner)
                            <!-- Estado Inicial: "O vencedor é..." -->
                            <div class="mb-12">
                                <h2 class="text-4xl text-yellow-300 mb-8">
                                    🏆 O vencedor é... 🏆
                                </h2>
                                <button
                                    wire:click="revealWinner"
                                    class="px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white text-2xl font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-2xl animate-pulse"
                                >
                                    Clique para Revelar! ✨
                                </button>
                            </div>
                        @else
                            <!-- Revelação do Vencedor -->
                            <div class="reveal-animation">
                                <!-- Card do Vencedor -->
                                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 shadow-2xl border border-white/20 max-w-2xl mx-auto">
                                    @if($alternative['winner']['photo'])
                                        <div class="mb-6">
                                            <img src="{{ Storage::url($alternative['winner']['photo']) }}"
                                                 alt="{{ $alternative['winner']['name'] }}"
                                                 class="w-48 h-48 object-cover rounded-full mx-auto border-8 border-yellow-400 shadow-2xl winner-photo">
                                        </div>
                                    @endif

                                    <h3 class="text-5xl font-bold text-white mb-6 winner-name">
                                        {{ $alternative['winner']['name'] }}
                                    </h3>

                                    <!-- Estatísticas -->
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="bg-white/20 rounded-xl p-4 stats-card">
                                            <div class="text-3xl font-bold text-yellow-300">{{ $alternative['winner']['votes'] }}</div>
                                            <div class="text-sm text-white/80">Votos Recebidos</div>
                                        </div>
                                        <div class="bg-white/20 rounded-xl p-4 stats-card">
                                            <div class="text-3xl font-bold text-yellow-300">
                                                {{ $alternative['winner']['total_votes'] > 0 ? round(($alternative['winner']['votes'] / $alternative['winner']['total_votes']) * 100, 1) : 0 }}%
                                            </div>
                                            <div class="text-sm text-white/80">dos Votos Totais</div>
                                        </div>
                                    </div>

                                    <!-- Confete Animation -->
                                    <div class="text-6xl animate-bounce celebration">
                                        🎉 🏆 🎉
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Indicadores de Slide -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
            @foreach($alternatives as $index => $alternative)
                <button
                    wire:click="goToSlide({{ $index }})"
                    class="w-3 h-3 rounded-full transition-all duration-300 {{ $currentSlide === $index ? 'bg-yellow-400 scale-125' : 'bg-white/40 hover:bg-white/60' }}"
                    title="{{ $alternative['title'] }}"
                ></button>
            @endforeach
        </div>

        <!-- Contador de Slides -->
        <div class="absolute bottom-4 right-4 text-white/60 text-sm">
            {{ $currentSlide + 1 }} / {{ $totalSlides }}
        </div>
    @else
        <!-- Sem Dados -->
        <div class="flex items-center justify-center min-h-screen">
            <div class="text-center text-white">
                <div class="text-8xl mb-8">🏆</div>
                <h1 class="text-4xl font-bold mb-4">Nenhum Vencedor Ainda</h1>
                <p class="text-xl text-white/70 mb-8">
                    Não há votações com resultados suficientes para determinar vencedores.
                </p>
                <a href="{{ route('admin.home') }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Voltar ao Painel Admin
                </a>
            </div>
        </div>
    @endif

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes reveal-winner {
            0% { opacity: 0; transform: scale(0.8) translateY(50px); }
            50% { opacity: 1; transform: scale(1.1) translateY(-10px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes photo-reveal {
            0% { opacity: 0; transform: scale(0) rotate(180deg); }
            60% { opacity: 1; transform: scale(1.2) rotate(-10deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        @keyframes stats-pop {
            0% { opacity: 0; transform: scale(0.8); }
            50% { transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }

        @keyframes celebration-bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0) scale(1); }
            40% { transform: translateY(-20px) scale(1.2); }
            60% { transform: translateY(-10px) scale(1.1); }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }

        .reveal-animation {
            animation: reveal-winner 1s ease-out;
        }

        .winner-photo {
            animation: photo-reveal 1.2s ease-out 0.3s both;
        }

        .winner-name {
            animation: fade-in 1s ease-out 0.6s both;
        }

        .stats-card {
            animation: stats-pop 0.8s ease-out 0.9s both;
        }

        .stats-card:nth-child(2) {
            animation-delay: 1.1s;
        }

        .celebration {
            animation: celebration-bounce 2s ease-in-out 1.3s both;
        }

        /* Efeito de partículas de fundo */
        .min-h-screen::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            pointer-events: none;
        }
    </style>
</div>

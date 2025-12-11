<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">Dashboard do Usuário</h1>
        <p class="text-zinc-600 dark:text-zinc-400">Bem-vindo, {{ auth()->user()->name }}!</p>
    </div>

    @if($activeAlternative)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Votação Atual -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Votação Ativa</h2>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $activeAlternative->title }}</p>
                </div>
                <div class="p-6">
                    @if($hasVoted)
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">Você já votou!</p>
                                    <p class="text-xs text-green-600 dark:text-green-300">Sua escolha: {{ $userVote->option->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h3 class="font-medium text-zinc-900 dark:text-white">Opções disponíveis:</h3>
                            @foreach($activeAlternative->options as $option)
                                <div class="flex items-center justify-between p-3 rounded border {{ $userVote->option_id == $option->id ? 'border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-800' : 'border-zinc-200 dark:border-zinc-700' }}">
                                    <div class="flex items-center">
                                        @if($userVote->option_id == $option->id)
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $option->name }}</span>
                                    </div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $option->vote_count }} votos</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <svg class="w-12 h-12 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Pronto para votar?</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">{{ $activeAlternative->options->count() }} opções disponíveis</p>
                            <a href="{{ route('vote') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Votar Agora
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Estatísticas -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Estatísticas</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Total de votos</span>
                        <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $activeAlternative->votes->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Opções disponíveis</span>
                        <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $activeAlternative->options->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Sua participação</span>
                        <span class="text-lg font-semibold {{ $hasVoted ? 'text-green-600' : 'text-orange-600' }}">
                            {{ $hasVoted ? 'Participou' : 'Pendente' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm p-8 text-center">
            <svg class="w-16 h-16 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">Nenhuma votação ativa</h2>
            <p class="text-zinc-600 dark:text-zinc-400">No momento não há alternativas disponíveis para votação. Volte em breve!</p>
        </div>
    @endif
</div>

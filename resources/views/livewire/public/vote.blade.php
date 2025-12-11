<div class="p-6 max-w-4xl mx-auto">
    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium text-red-800 dark:text-red-200">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif

    @if($activeAlternative)
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $activeAlternative->title }}</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    @if($hasVoted)
                        Você já votou nesta alternativa
                    @else
                        Escolha sua opção favorita
                    @endif
                </p>
            </div>

            <div class="p-6">
                @if($hasVoted)
                    <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                Você votou em: <strong>{{ $userVote->option->name }}</strong>
                            </p>
                        </div>
                    </div>
                @endif

                <form wire:submit="vote" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($activeAlternative->options as $option)
                            <label class="relative cursor-pointer {{ $hasVoted ? 'cursor-not-allowed opacity-50' : '' }}">
                                <input
                                    type="radio"
                                    wire:model.live="selectedOptionId"
                                    value="{{ $option->id }}"
                                    class="sr-only"
                                    {{ $hasVoted ? 'disabled' : '' }}
                                >
                                <div class="border-2 rounded-lg p-4 transition-all duration-200
                                    @if($selectedOptionId == $option->id)
                                        border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-2 ring-blue-200 dark:ring-blue-800
                                    @else
                                        border-zinc-200 dark:border-zinc-700
                                    @endif
                                    {{ !$hasVoted ? 'hover:border-blue-300 hover:bg-zinc-50 dark:hover:bg-zinc-700/50' : '' }}">

                                    @if($option->photo)
                                        <div class="mb-3">
                                            <img src="{{ Storage::url($option->photo) }}"
                                                 alt="{{ $option->name }}"
                                                 class="w-full h-32 object-cover rounded">
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if($selectedOptionId == $option->id)
                                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <div class="w-5 h-5 border-2 border-zinc-300 dark:border-zinc-600 rounded-full mr-2"></div>
                                            @endif
                                            <h3 class="font-medium text-zinc-900 dark:text-white">{{ $option->name }}</h3>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($hasVoted && $userVote->option_id == $option->id)
                                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                            <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $option->vote_count }} {{ $option->vote_count === 1 ? 'voto' : 'votos' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="col-span-2 text-center py-8">
                                <p class="text-zinc-500 dark:text-zinc-400">Nenhuma opção disponível para votação.</p>
                            </div>
                        @endforelse
                    </div>

                    @if(!$hasVoted && $activeAlternative->options->count() > 0)
                        <div class="flex justify-center pt-4">
                            <flux:button
                                type="submit"
                                variant="primary"
                                wire:loading.attr="disabled"
                                wire:target="vote"
                            >
                                <span wire:loading.remove wire:target="vote">Confirmar Voto</span>
                                <span wire:loading wire:target="vote">Registrando voto...</span>
                            </flux:button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm p-8 text-center">
            <svg class="w-12 h-12 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">Nenhuma votação ativa</h2>
            <p class="text-zinc-600 dark:text-zinc-400">No momento não há alternativas disponíveis para votação.</p>
        </div>
    @endif
</div>

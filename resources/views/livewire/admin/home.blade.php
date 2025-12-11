<div class="p-6">
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('message') }}
                </p>
            </div>
        </div>
    @endif

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Criar Nova Alternativa</h2>
        <form wire:submit="createAlternative" class="flex gap-3">
            <flux:input
                wire:model="title"
                placeholder="Título da alternativa"
                class="flex-1"
                variant="filled"
            />
            <flux:button
                type="submit"
                variant="primary"
                icon="plus"
                wire:loading.attr="disabled"
                wire:target="createAlternative"
            >
                <span wire:loading.remove wire:target="createAlternative">Criar</span>
                <span wire:loading wire:target="createAlternative">Criando...</span>
            </flux:button>
        </form>
        @error('title')
            <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Painel de Controle Geral -->
    <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-sm font-medium text-blue-900 dark:text-blue-200">Controle de Votação</h3>
                <p class="text-xs text-blue-700 dark:text-blue-300">
                    Gerencie quais alternativas estão liberadas para votação. Alternativas inativas não aparecem para os usuários.<br>
                    <strong>Importante:</strong> Apenas uma alternativa pode estar ativa por vez. Ao ativar uma, todas as outras são automaticamente desativadas.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 text-xs">
                <a href="{{ route('admin.winners') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white px-4 py-2 rounded-lg transition-all duration-200 font-medium shadow-lg">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    🏆 Ver Vencedores
                </a>
                <div class="flex items-center gap-2 bg-white dark:bg-zinc-800 px-3 py-2 rounded border">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        {{ $alternatives->where('active', true)->count() }} Ativas
                    </span>
                </div>
                <div class="flex items-center gap-2 bg-white dark:bg-zinc-800 px-3 py-2 rounded border">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                        {{ $alternatives->where('active', false)->count() }} Inativas
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($alternatives as $alternative)
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $alternative->title }}</h3>
                            @if($alternative->active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Ativo - Aceita Votos
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Inativo - Sem Votos
                                </span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            @if($alternative->active)
                                <flux:button
                                    wire:click="toggleAlternativeStatus({{ $alternative->id }})"
                                    variant="outline"
                                    icon="pause"
                                    size="sm"
                                    wire:confirm="Desativar esta alternativa? Os votos existentes serão mantidos, mas novos votos não serão aceitos."
                                >
                                    Desativar Votação
                                </flux:button>
                            @else
                                <flux:button
                                    wire:click="toggleAlternativeStatus({{ $alternative->id }})"
                                    variant="primary"
                                    icon="play"
                                    size="sm"
                                    wire:confirm="Ativar esta alternativa? Todas as outras alternativas ativas serão automaticamente desativadas, pois apenas uma pode estar ativa por vez."
                                >
                                    Liberar Votação
                                </flux:button>
                            @endif
                            <flux:button
                                wire:click="openModal({{ $alternative->id }})"
                                variant="primary"
                                icon="plus"
                                size="sm"
                            >
                                Adicionar Opção
                            </flux:button>
                            <flux:button
                                wire:click="deleteAlternative({{ $alternative->id }})"
                                wire:confirm="Tem certeza?"
                                variant="danger"
                                icon="trash"
                                size="sm"
                            >
                                Excluir
                            </flux:button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if($alternative->options->isEmpty())
                        <div class="text-center py-8 text-zinc-500">
                            <div class="mx-auto h-8 w-8 mb-2 opacity-50 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-sm">Nenhuma opção adicionada ainda</p>
                        </div>
                    @else
                        <!-- Estatísticas da alternativa -->
                        <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Total de opções: {{ $alternative->options->count() }}</span>
                                <span class="font-semibold text-zinc-900 dark:text-white">
                                    Total de votos: {{ $alternative->options->sum('votes') }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($alternative->options as $option)
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 bg-zinc-50 dark:bg-zinc-800/50">
                                @if($option->photo)
                                    <div class="relative mb-3">
                                        <img src="{{ asset('storage/' . $option->photo) }}"
                                             alt="{{ $option->name }}"
                                             class="w-full h-40 object-cover rounded-lg">
                                    </div>
                                @endif
                                <div class="space-y-2">
                                    <h4 class="font-medium text-sm text-zinc-900 dark:text-white">{{ $option->name }}</h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200">
                                        {{ $option->votes }} {{ $option->votes === 1 ? 'voto' : 'votos' }}
                                    </span>
                                    <flux:button
                                        wire:click="deleteOption({{ $option->id }})"
                                        wire:confirm="Tem certeza?"
                                        variant="danger"
                                        size="xs"
                                        icon="trash"
                                    >
                                        Remover
                                    </flux:button>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm text-center py-12">
                <div class="mx-auto h-12 w-12 text-zinc-400 mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-zinc-500 mb-2">Nenhuma alternativa criada</h2>
                <p class="text-sm text-zinc-400">Crie sua primeira alternativa usando o formulário acima</p>
            </div>
        @endforelse
    </div>

    <!-- Modal único para adicionar opção -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
             x-data x-on:click.self="$wire.closeModal()">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full max-w-md mx-4">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Adicionar Opção</h3>
                </div>

                <form wire:submit="addOption">
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Nome da Opção
                            </label>
                            <flux:input
                                wire:model="optionName"
                                placeholder="Digite o nome da opção"
                                class="w-full"
                            />
                            @error('optionName')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Foto (opcional)
                            </label>
                            <flux:input
                                type="file"
                                wire:model="optionPhoto"
                                accept="image/*"
                                class="w-full"
                            />
                            @error('optionPhoto')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror

                            @if($optionPhoto)
                                <div class="mt-3">
                                    <span class="inline-block text-xs bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200 px-2 py-1 rounded mb-2">
                                        Preview da imagem:
                                    </span>
                                    <img src="{{ $optionPhoto->temporaryUrl() }}"
                                         class="w-24 h-24 object-cover rounded-lg border-2 border-zinc-200 dark:border-zinc-700 shadow-sm">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex gap-3">
                        <flux:button
                            type="submit"
                            variant="primary"
                            class="flex-1"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Salvar Opção</span>
                            <span wire:loading>Salvando...</span>
                        </flux:button>
                        <flux:button
                            type="button"
                            wire:click="closeModal"
                            variant="ghost"
                            class="flex-1"
                        >
                            Cancelar
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Your Client") }}
                    @if ($clients->count() !== 0)
                        @foreach ($clients as $client)
                            <h5>Client Name: {{$client->name}}</h5>
                            <h5>Client ID: {{$client->id}}</h5>
                            <h5>Client Serect: {{$client->secret}}</h5>
                            <h5>Callback: {{$client->redirect}}</h5>
                            <p>---------------------</p>
                        @endforeach
                    @else
                        <h5>You Dont Have Any Client</h5>
                    @endif
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h5 class="mb-4">Create Client</h5>
                    <form method="POST" action="/oauth/clients">
                        @csrf
                
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Client Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>
                
                        <!-- redirect -->
                        <div class="mt-2">
                            <x-input-label for="redirect" :value="__('Redirect')" />
                            <x-text-input id="redirect" class="block mt-1 w-full" type="text" name="redirect" :value="old('redirect')" required autofocus autocomplete="name" />
                        </div>
                
                        
                
                        
                
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

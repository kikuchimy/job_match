<x-app-layout>
    <x-slot name="script">
        <script src="{{ mix('js/message.js') }}" defer></script>
    </x-slot>
    {{-- チャット画面 --}}
    <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col h-screen max-w-7xl mx-auto">
        <div class="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
            <div class="relative flex items-center space-x-4">
                @can('user')
                    <div class="relative">
                        {{-- オンライン状態の表示(未実装) --}}
                        <span class="absolute text-green-500 right-0 bottom-0">
                            <svg width="20" height="20">
                                <circle cx="8" cy="8" r="8" fill="currentColor"></circle>
                            </svg>
                        </span>
                        {{-- 企業アカウントの画像 --}}
                        <img src="{{ $entry->jobOffer->company->profile_photo_url }}" alt=""
                            class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
                    </div>
                    {{-- 企業アカウントの名前 --}}
                    <div class="flex flex-col leading-tight">
                        <div class="text-2xl mt-1 flex items-center">
                            <span class="text-gray-700 mr-3">{{ $entry->jobOffer->company->name }}</span>
                        </div>
                        {{-- <span class="text-lg text-gray-600">{{  $entry->jobOffer->company->user->name }}</span> --}}
                    </div>
                @endcan
                @can('company')
                    <div class="relative">
                        {{-- オンライン状態の表示(未実装) --}}
                        <span class="absolute text-green-500 right-0 bottom-0">
                            <svg width="20" height="20">
                                <circle cx="8" cy="8" r="8" fill="currentColor"></circle>
                            </svg>
                        </span>
                        {{-- ユーザーアカウントの画像 --}}
                        <img src="{{ $entry->user->profile_photo_url }}" alt=""
                            class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
                    </div>
                    {{-- ユーザーアカウントの名前 --}}
                    <div class="flex flex-col leading-tight">
                        <div class="text-2xl mt-1 flex items-center">
                            <span class="text-gray-700 mr-3">{{ $entry->user->name }}</span>
                        </div>
                        {{-- <span class="text-lg text-gray-600">Junior Developer</span> --}}
                    </div>
                @endcan

            </div>
            <div class="flex items-center space-x-2">
                {{-- メッセージ検索ボタン(未実装) --}}
                <button type="button"
                    class="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                {{-- お気に入りボタン(未実装) --}}
                <button type="button"
                    class="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </button>
                {{-- 通知ボタン(未実装) --}}
                <button type="button"
                    class="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="messages"
            class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
            @foreach ($messages as $message)
                @if ($message->user_id == Auth::user()->id)
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            {{-- メッセージ削除ボタン --}}
                            <button class="delete-button" id="{{ $message->id }}" type="button">
                                {{-- pointer-events-noneで、svgをポインターイベントの対象から外す --}}
                                <svg class="w-6 h-6 text-gray-600 pointer-events-none" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                            {{-- メッセージの送信時間 --}}
                            <div class="text-gray-600 text-sm">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</div>
                            {{-- メッセージ内容 --}}
                            <div class="flex flex-col space-y-2 text-lg max-w-lg mx-2 items-end">
                                <div>
                                    <span
                                        class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white">{{ $message->message }}</span>
                                </div>
                            </div>
                            {{-- ログインユーザーのプロフィール画像と名前 --}}
                            <img class="w-6 h-6 rounded-full" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                        </div>
                    </div>
                @else
                    <div class="chat-message">
                        <div class="flex items-end">
                            {{-- チャット相手のプロフィール画像と名前 --}}
                            <img class="w-6 h-6 rounded-full" src="{{ $message->user->profile_photo_url }}"
                                alt="{{ $message->user->name }}" />
                            {{-- メッセージ内容 --}}
                            <div class="flex flex-col space-y-2 text-lg max-w-lg mx-2 items-start">
                                <div>
                                    <span
                                        class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">{{ $message->message }}</span>
                                </div>
                            </div>
                            {{-- メッセージの送信時間 --}}
                            <div class="text-gray-600 text-sm">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        {{-- メッセージ入力欄 --}}
        <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0 sticky bottom-2">
            <div class="relative flex">
                <span class="absolute inset-y-0 flex items-center">
                    {{-- 音声入力(未実装) --}}
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="h-6 w-6 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                    </button>
                </span>
                <input type="hidden" id="current_user_id" name="current_user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" id="messageable_id" name="messageable_id" value="{{ $entry->id }}">
                <input type="text" placeholder="メッセージを入力" id="message" name="message"
                    class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 bg-gray-200 rounded-md py-3">
                <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                    {{-- リンクボタン(未実装) --}}
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="h-6 w-6 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                            </path>
                        </svg>
                    </button>
                    {{-- カメラボタン(未実装) --}}
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="h-6 w-6 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                    {{-- 絵文字ボタン(未実装) --}}
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" class="h-6 w-6 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </button>
                    {{-- メッセージ送信ボタン --}}
                    <button type="button" id="submit"
                        class="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
                        <span class="font-bold">送信</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="h-6 w-6 ml-2 transform rotate-90">
                            <path
                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

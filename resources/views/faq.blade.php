@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-8">FAQ</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($faqs as $index => $faq)
        <div class="bg-black text-white rounded-3xl overflow-hidden shadow-md transition-all duration-300 cursor-pointer"
            onclick="toggleFaq({{ $index }})" id="faq-{{ $index }}">
            <div class="flex justify-between items-center px-6 py-4">
                <span class="font-semibold">{{ $faq['question'] }}</span>
                <span id="symbol-{{ $index }}" class="text-xl font-bold">+</span>
            </div>
            <div id="answer-{{ $index }}" class="bg-white text-black px-6 py-4 hidden">
                {{ $faq['answer'] }}
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function toggleFaq(index) {
        const answer = document.getElementById('answer-' + index);
        const symbol = document.getElementById('symbol-' + index);

        if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            symbol.innerText = '-';
        } else {
            answer.classList.add('hidden');
            symbol.innerText = '+';
        }
    }
</script>
@endsection

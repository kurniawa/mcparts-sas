<div class="text-slate-700 text-xs">
    To attain knowledge, add things every day; To attain wisdom, subtract things every day.
    {{-- @livewire('spks') --}}
    @foreach ($spks as $spk)
    <div>{{ $spk->no_spk }}</div>
    @endforeach
</div>

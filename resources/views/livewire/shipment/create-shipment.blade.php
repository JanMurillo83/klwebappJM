<div>
    <div style="margin-top: 15px !important; margin-bottom:20px !important; margin-left:15px !important;">
        <label style="font-size: 25px"><b>{{$this->title}}</b></label>
    </div>
    <hr>
    <form wire:submit="create">
        {{ $this->form }}
    </form>

    <x-filament-actions::modals />
</div>

<div class="form-group row">
    <div class="col-12">
        <input class="form-control form-control-title" type="text" style=""
               @if(isset($translation)) value="{{$translation->title}}" @endif
               name="title" placeholder="Введите заголовок..." required>
    </div>
</div>

@push('styles')

    <style>
        .form-control-title {
            height: calc(1.5em + 1.65rem + 20px);
            padding: 0.90rem 1.50rem;
            font-size: 1.40rem;
            line-height: 1.5;
            border-radius: 0.42rem;
            background-color: rgba(216, 228, 253, 0.31);
            font-weight: 700;
        }
    </style>

@endpush

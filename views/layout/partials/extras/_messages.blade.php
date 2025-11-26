{{-- Mensajes tipo toastr --}}
@if ($toastr = Session::get('response'))
<span class="d-none" data-messages="toastr" data-type="{{ $toastr[0] }}" data-title="{{ $toastr[1] }}" data-desc="{{ $toastr[2] }}" data-position="{{ empty($toastr[3]) ? 'toast-bottom-right' : $toastr[3] }}"></span>
@endif

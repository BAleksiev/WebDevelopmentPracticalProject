
function generateNoty(text, type, layout) {
if(layout == null) {
layout = 'topCenter';
}

var n = noty({
text        : text,
type        : type,
timeout     : 10000,
closeWith   : ['click'],
layout      : layout,
theme       : 'defaultTheme'
});
}

@if($errors)
@foreach($errors->all() as $error)
generateNoty('{{ $error }}', 'error');
@endforeach
@endif

@if(Session::get('error'))
generateNoty('{{ Session::get('error') }}', 'error');
@endif
@if(Session::get('message'))
generateNoty('{{ Session::get('message') }}', 'information');
@endif
@if(Session::get('success'))
generateNoty('{{ Session::get('success') }}', 'success');
@endif
@if(Session::get('systemMessage'))
generateNoty('{{ Session::get('systemMessage') }}', 'information', 'center');
@endif
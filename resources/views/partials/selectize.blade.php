<script type="text/javascript">
$(function() {

	if($('{!! $id !!}').hasClass('selectized')){
		$('{!! $id !!}').next().remove();
	}
	
	$('{!! $id !!}').selectize({
		valueField: '{!! $valueField !!}',
		labelField: '{!! $labelField !!}',
		searchField: ['{!! $labelField !!}'],
		render: {
			option: function(item, escape) {
				var texto = '';
				@if(isset($showFields))
				 	@foreach ($showFields as $k => $v) 
				        texto += '<strong>{!! $k !!}:</strong> '+ escape(item.{!! $v !!}) + ' ';
				    @endforeach
					texto = '<div>' + texto + '</div>'; 
				@else
					texto = '<div> <strong>Nombre:</strong> ' + escape(item.{!! $labelField !!}) + '</div>';
				@endif
				return texto;
			}
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: '{!! $url !!}',
				type: 'GET',
				dataType: 'json',
				data: {
					nombre: query
				},
				success: function(res) {
					callback(res);
				}
			});
		}
	});
	
});
</script>
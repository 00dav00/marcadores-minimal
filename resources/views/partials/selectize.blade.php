<script type="text/javascript">
$(function() {
	$('{!! $id !!}').selectize({
		valueField: '{!! $valueField !!}',
		labelField: '{!! $labelField !!}',
		searchField: ['{!! $labelField !!}'],
		render: {
			option: function(item, escape) {
				return '<div> <strong>Nombre:</strong> ' + escape(item.{!! $labelField !!}) + '</div>';
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
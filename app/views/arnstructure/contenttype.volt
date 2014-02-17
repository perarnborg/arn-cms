{{ content() }}

<h1>{{ contentType.id ? contentType.title : 'New Content Type' }}</h1>

<form class="arn-edit-form" method="post">
	<div class="arn-field-group">
		<label for="content-type-title">Title</label>
		<input type="text" id="content-type-title" value="{{ contentType.title }}" />
	</div>
	<div class="arn-field-group">
		<label for="content-type-title">Title</label>
		<input type="text" id="content-type-title" value="{{ contentType.title }}" />
	</div>
	<div class="arn-field-group">
		<label for="content-type-title">Title</label>
		<input type="text" id="content-type-title" value="{{ contentType.title }}" />
	</div>
	<h2>Custom fields</h2>
	{% for index, field in fields %}
	<div class="arn-field">
		<div class="arn-field-group">
			<label for="content-type-field-title">Title</label>
			<input type="text" id="content-type-field-title" value="{{ field.title }}" />
		</div>	
		<div class="arn-field-group">
			<label for="content-type-field-description">Description</label>
			<input type="text" id="content-type-field-description" value="{{ field.description }}" />
		</div>	
		<div class="arn-field-group">
			<label for="content-type-field-value-type">Value type</label>
			<select id="content-type-field-value-type">
				<option value="string"{{ ' selected="selected"' if field.value_type == 'string' }}>String</option>
				<option value="integer"{{ ' selected="selected"' if field.value_type == 'integer' }}>Integer</option>
				<option value="double"{{ ' selected="selected"' if field.value_type == 'double' }}>Double</option>
			</select>
		</div>	
	</div>
	{% endfor %}
	<a href="#" class="toggle-trigger">Add new field</a>
	<div class="toggle-area arn-field arn-field-new hidden">
		<div class="arn-field-group">
			<label for="content-type-field-title">Title</label>
			<input type="text" id="content-type-field-title" />
		</div>	
		<div class="arn-field-group">
			<label for="content-type-field-description">Description</label>
			<input type="text" id="content-type-field-description" />
		</div>	
		<div class="arn-field-group">
			<label for="content-type-field-value-type">Value type</label>
			<select id="content-type-field-value-type">
				<option value="string">String</option>
				<option value="integer">Integer</option>
				<option value="double">Double</option>
			</select>
		</div>	
	</div>
</form>
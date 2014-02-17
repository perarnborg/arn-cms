{{ content() }}

<h1>Taxonomies</h1> 

<a href="/arnstructure/taxonomy">Create new</a>

<ul>
	{% for index, taxonomy in taxonomies %}
    <li><a href="/arnstructure/taxonomy/{{ taxonomy.id }}">{{ taxonomy.title }}</a></li>
    {% endfor %}
</ul>

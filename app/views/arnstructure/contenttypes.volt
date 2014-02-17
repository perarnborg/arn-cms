{{ content() }}

<h1>Content Types</h1>

<a href="/arnstructure/contenttype">Create new</a>

<ul>
	{% for index, contentType in contentTypes %}
    <li><a href="/arnstructure/contenttype/{{ contentType.id }}">{{ contentType.title }}</a></li>
    {% endfor %}
</ul>

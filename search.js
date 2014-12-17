---
layout: none
---
var docs = 
[ 
{% for post in site.posts limit:20 %}
  {
    "id"    : "{{ post.url }}",
    "title"   : "{{ post.title }}",
    "content" : "{% if post.description %}{{ post.description | strip_html | strip_newlines | remove:'"' }}{% else %}{{ post.excerpt | strip_html | strip_newlines | remove:'"'}}{% endif %}"
  },
{% endfor %}
];
// init lunr
var idx = lunr(function () {
  this.field('title', 10);
  this.field('content');
})
// add each document to be index
for(var index in docs) {
  idx.add(docs[index]);
}

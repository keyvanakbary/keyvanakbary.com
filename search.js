---
---
var docs = 
[ 
{% for post in site.posts limit:20 %}
  {
    "id"    : "http://keyvanakbary.com{{ post.url }}",
    "title"   : "{{ post.title }}",
    "content" : "{{ post.content | strip_html | strip_newlines | remove:'"'  }}"
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

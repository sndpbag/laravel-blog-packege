<x-mail::message>
# New Blog Post Published! 🚀

Hello there,

We are excited to announce a new post on our blog! Dive in and discover the latest insights.

## **{{ $blog->title }}**

@if($blog->excerpt)
>"{{ $blog->excerpt }}"
@endif

<x-mail::button :url="$url">
Read Full Post
</x-mail::button>

### Post Details:
* **Author:** {{ $blog->author->name ?? 'Our Team' }}
* **Reading Time:** {{ $blog->reading_time }} minutes
* **Category:** {{ $blog->category->name ?? 'General' }}

We hope you enjoy the read!

Thank you for being a valued subscriber,<br>
{{ config('app.name') }}
</x-mail::message>
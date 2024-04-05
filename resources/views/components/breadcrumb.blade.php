@props(['name'=>'','data' => null])
<div class="mt-2 text-sm font-bold">
    {{ Breadcrumbs::render($name, $data) }}
</div>

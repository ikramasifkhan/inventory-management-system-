<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading pt-5"><strong>{{auth()->user()->name}}</strong></div>
    <div class="list-group list-group-flush">
        <a href="{{route('supplier.dashboard')}}" class="list-group-item list-group-item-action bg-light">Supplier Dashboard</a>
        <a href="{{route('suppliers.panel.edit', ['id'=>$supplier->id])}}" class="list-group-item list-group-item-action bg-light">Update your company info</a>
    </div>
</div>

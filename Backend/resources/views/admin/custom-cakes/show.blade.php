@extends('admin.layout')

@section('content')
<div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Request #{{ $request->reference_number }}</h2>
    <a href="{{ route('admin.custom-cakes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Requests
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
    <!-- Technical Details -->
    <div>
        <form action="{{ route('admin.custom-cakes.update-status', $request->id) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white;">
                <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Specifications</h3>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="color: #666; font-size: 12px;">Cake Type / Name</label>
                    <input type="text" name="cake_name" class="form-control" value="{{ $request->cake_name }}">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label style="color: #666; font-size: 12px;">Size</label>
                        <input type="text" name="size" class="form-control" value="{{ $request->size }}">
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px;">Flavor</label>
                        <input type="text" name="flavor" class="form-control" value="{{ $request->flavor }}">
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px;">Frosting</label>
                        <input type="text" name="frosting" class="form-control" value="{{ $request->frosting }}">
                    </div>
                    <div>
                        <label style="color: #666; font-size: 12px;">Delivery Date</label>
                        <div style="font-weight: 600; color: var(--primary); padding: 8px 0;">
                            {{ $request->delivery_date->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: #666; font-size: 12px;">Decorations</label>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 5px;">
                        @if($request->decorations)
                            @foreach($request->decorations as $dec)
                                <span style="background: #f0f0f0; padding: 4px 10px; border-radius: 4px; font-size: 13px;">{{ $dec['name'] ?? $dec }}</span>
                            @endforeach
                        @else
                            <span style="color: #999;">No decorations selected</span>
                        @endif
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="color: #666; font-size: 12px;">Custom Message</label>
                    <textarea name="custom_message" class="form-control" rows="2">{{ $request->custom_message }}</textarea>
                </div>

                <div style="padding: 15px; background: #fff8f0; border-radius: 10px; border: 1px solid #ffe5d0;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <strong>Estimated Total:</strong>
                        <span style="font-size: 1.5rem; font-weight: 700; color: var(--secondary);">Rs {{ number_format($request->total_price, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white;">
                <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Management</h3>
                
                <div class="form-group">
                    <label>Review Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approved (Quote Sent)</option>
                        <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="delivered" {{ $request->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected / Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Final Quoted Price (Optional)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 10px; top: 10px; color: #666;">Rs</span>
                        <input type="number" name="total_price" class="form-control" style="padding-left: 35px;" value="{{ $request->total_price }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Request</button>
            </div>
        </form>
    </div>

    <!-- Design Preview -->
    <div>
        <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white; text-align: center;">
            <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; text-align: left;">Design Inspiration</h3>
            @if($request->image_path)
                <img src="{{ asset('storage/' . $request->image_path) }}" alt="Design Inspiration" style="max-width: 100%; height: auto; max-height: 500px; object-fit: contain; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #eee;">
            @else
                <div style="padding: 60px; background: #f8f8f8; border-radius: 10px; border: 2px dashed #ddd; color: #999;">
                    <i class="fas fa-image" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                    No image uploaded
                </div>
            @endif
            
            <div style="margin-top: 20px; text-align: left; padding: 15px; background: #f4f6f9; border-radius: 10px;">
                <h4 style="margin-bottom: 10px; font-size: 14px; color: var(--secondary);">Customer Information</h4>
                <div style="font-size: 14px;"><strong>Name:</strong> {{ $request->user->name ?? 'Guest' }}</div>
                <div style="font-size: 14px;"><strong>Email:</strong> {{ $request->user->email ?? '' }}</div>
                <div style="font-size: 14px;"><strong>Phone:</strong> {{ $request->user->phone ?? '' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

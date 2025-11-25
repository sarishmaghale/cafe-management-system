 <!-- Stats Bar -->
 <div class="stats-bar">
     <div class="stat-item">
         <div class="stat-number">{{ $result['totalOrders'] }}</div>
         <div class="stat-label">Total Orders</div>
     </div>
     <div class="stat-item">
         <div class="stat-number">{{ $result['newOrders'] }}</div>
         <div class="stat-label">New Orders</div>
     </div>
 </div>

 <!-- Orders Grid -->
 <div class="orders-grid" id="ordersGrid">
     @foreach ($result['orders'] as $order)
         <div class="order-card new-order">
             <span class="new-badge"><i class="fas fa-bell me-1"></i>NEW</span>
             <div class="order-header">
                 <span class="order-type dine-in">
                     <i class="fas fa-chair me-1"></i>
                     {{ $order['station_name'] }}
                 </span>
                 <div class="order-time">{{ $order['created_at'] }}</div>
             </div>

             <div class="order-items">
                 <div class="order-item">
                     <span class="item-name">{{ $order['product_name'] }}</span>
                     <span class="item-quantity">x{{ $order['quantity'] }}</span>
                 </div>
             </div>

             <button class="btn-preparing" onclick="markPreparing({{ $order['id'] }})">
                 <i class="fas fa-check me-2"></i>Preparing
             </button>
         </div>
     @endforeach

 </div>

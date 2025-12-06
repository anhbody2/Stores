import './bootstrap';
// product-detail.js - Xử lý trang chi tiết sản phẩm

document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra xem có trên trang chi tiết sản phẩm không
    const productDetailElements = document.querySelectorAll('.product-gallery, .product-title');
    if (productDetailElements.length === 0) return;

    console.log('Initializing product detail page...');

    // Xử lý thumbnail click
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Xóa active class
            document.querySelectorAll('.thumbnail').forEach(t => {
                t.classList.remove('active');
            });
            
            // Thêm active class
            this.classList.add('active');
            
            // Thay đổi ảnh chính
            const newImageSrc = this.getAttribute('data-image');
            const zoomImageSrc = this.getAttribute('data-zoom');
            
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = newImageSrc;
                mainImage.setAttribute('data-zoom', zoomImageSrc);
            }
        });
    });

    // Xử lý số lượng
    const increaseBtn = document.getElementById('increaseQty');
    const decreaseBtn = document.getElementById('decreaseQty');
    
    if (increaseBtn) {
        increaseBtn.addEventListener('click', function() {
            const quantityInput = document.getElementById('quantity');
            if (quantityInput) {
                let currentValue = parseInt(quantityInput.value);
                const max = parseInt(quantityInput.max) || 999;
                
                if (currentValue < max) {
                    quantityInput.value = currentValue + 1;
                }
            }
        });
    }

    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', function() {
            const quantityInput = document.getElementById('quantity');
            if (quantityInput) {
                let currentValue = parseInt(quantityInput.value);
                
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            }
        });
    }

    // Xử lý thêm vào giỏ hàng
    const addToCartBtn = document.getElementById('addToCart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const quantityInput = document.getElementById('quantity');
            const quantity = quantityInput ? quantityInput.value : 1;
            const productName = document.querySelector('.product-title') ? 
                               document.querySelector('.product-title').textContent.trim() : 
                               'Sản phẩm';
            
            // Lấy giá từ data attribute hoặc parse từ text
            let price = 0;
            const priceElement = document.querySelector('.current-price');
            if (priceElement) {
                const priceText = priceElement.textContent.replace(/[^\d]/g, '');
                price = parseInt(priceText) || 0;
            }
            
            const total = price * quantity;
            
            // Hiệu ứng
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check btn-icon"></i> Đã thêm vào giỏ';
            this.style.backgroundColor = '#2ecc71';
            
            setTimeout(() => {
                this.innerHTML = originalHTML;
                this.style.backgroundColor = '';
            }, 2000);
            
            // Thông báo
            showNotification(`Đã thêm ${quantity} "${productName}" vào giỏ hàng! Tổng: ${formatPrice(total)}`);
        });
    }

    // Xử lý mua ngay
    const buyNowBtn = document.getElementById('buyNow');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            const quantityInput = document.getElementById('quantity');
            const quantity = quantityInput ? quantityInput.value : 1;
            showNotification(`Chuyển đến trang thanh toán với ${quantity} sản phẩm...`);
        });
    }

    // Xử lý viết đánh giá
    const writeReviewBtn = document.getElementById('writeReview');
    if (writeReviewBtn) {
        writeReviewBtn.addEventListener('click', function() {
            showNotification('Tính năng viết đánh giá đang được phát triển!');
        });
    }

    // Xử lý zoom ảnh
    const mainImage = document.getElementById('mainImage');
    const zoomModal = document.getElementById('zoomModal');
    const zoomedImage = document.getElementById('zoomedImage');
    const closeZoom = document.querySelector('.close-zoom');

    if (mainImage && zoomModal && zoomedImage) {
        mainImage.addEventListener('click', function() {
            zoomModal.style.display = 'flex';
            zoomedImage.src = this.getAttribute('data-zoom');
        });

        if (closeZoom) {
            closeZoom.addEventListener('click', function() {
                zoomModal.style.display = 'none';
            });
        }

        zoomModal.addEventListener('click', function(e) {
            if (e.target === zoomModal) {
                zoomModal.style.display = 'none';
            }
        });
    }

    // Hàm hiển thị thông báo
    window.showNotification = function(message) {
        // Kiểm tra xem đã có toast container chưa
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '1050';
            document.body.appendChild(toastContainer);
        }

        // Tạo toast ID duy nhất
        const toastId = 'toast-' + Date.now();
        
        // Tạo toast
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = 'toast';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="toast-header bg-primary text-white">
                <strong class="me-auto">Thông báo</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Khởi tạo Bootstrap Toast
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 3000
        });
        bsToast.show();
        
        // Xóa toast sau khi ẩn
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    };

    // Hàm format số tiền
    window.formatPrice = function(price) {
        if (!price) return '0 ₫';
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " ₫";
    };

    // Thêm xử lý cho video
    const videoElements = document.querySelectorAll('video');
    videoElements.forEach(video => {
        video.addEventListener('click', function(e) {
            if (this.paused) {
                this.play();
            } else {
                this.pause();
            }
        });
    });

    console.log('Product detail page initialized successfully');
});
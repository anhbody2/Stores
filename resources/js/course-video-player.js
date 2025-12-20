
    document.addEventListener('DOMContentLoaded', function() {
        const videos = @json($videos);
        let currentVideoIndex = 0;
        
        // Lấy progress từ localStorage
        function getProgress() {
            const progress = localStorage.getItem('course_{{ $course->course_id }}_progress') || '{}';
            return JSON.parse(progress);
        }
        
        // Lưu progress vào localStorage
        function saveProgress(videoIndex) {
            const progress = getProgress();
            progress[videoIndex] = true;
            localStorage.setItem('course_{{ $course->course_id }}_progress', JSON.stringify(progress));
            updateProgressUI();
        }
        
        // Cập nhật giao diện progress
        function updateProgressUI() {
            const progress = getProgress();
            let completedCount = 0;
            
            // Cập nhật từng video
            videos.forEach((video, index) => {
                const progressCircle = document.getElementById(`progress-${index}`);
                if (progress[index]) {
                    progressCircle.classList.add('completed');
                    progressCircle.innerHTML = '<i class="fas fa-check"></i>';
                    completedCount++;
                } else {
                    progressCircle.classList.remove('completed');
                    progressCircle.textContent = index + 1;
                }
            });
            
            // Cập nhật overall progress
            const overallProgress = document.getElementById('overall-progress');
            const progressText = document.getElementById('progress-text');
            const progressPercent = videos.length > 0 ? (completedCount / videos.length) * 100 : 0;
            
            overallProgress.style.width = `${progressPercent}%`;
            progressText.textContent = `${completedCount}/${videos.length}`;
            
            // Đánh dấu video hiện tại là đã xem
            const progressCircle = document.getElementById(`progress-${currentVideoIndex}`);
            if (!progressCircle.classList.contains('completed')) {
                progressCircle.classList.add('completed');
                progressCircle.innerHTML = '<i class="fas fa-play"></i>';
            }
        }
        
        // Thay đổi video
        function changeVideo(index) {
            if (index < 0 || index >= videos.length) return;
            
            // Cập nhật active class
            document.querySelectorAll('.video-list-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelectorAll('.video-list-item')[index].classList.add('active');
            
            // Cập nhật video player
            const video = videos[index];
            let videoId = video.video_id || video.url || video;
            
            // Extract YouTube ID từ URL nếu cần
            if (videoId.includes('youtube.com') || videoId.includes('youtu.be')) {
                const match = videoId.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
                if (match) videoId = match[1];
            }
            
            // Cập nhật iframe
            const iframe = document.getElementById('youtube-player');
            iframe.src = `https://www.youtube.com/embed/${videoId}?rel=0&showinfo=0`;
            
            // Cập nhật thông tin video
            document.getElementById('current-video-title').textContent = 
                video.title || `Video ${index + 1}`;
            document.getElementById('current-video-description').textContent = 
                video.description || 'No description';
            
            // Cập nhật nút navigation
            document.getElementById('prev-video').disabled = index === 0;
            document.getElementById('next-video').disabled = index === videos.length - 1;
            
            // Cập nhật chỉ số hiện tại
            currentVideoIndex = index;
            
            // Lưu progress
            saveProgress(index);
            
            // Cuộn đến video trong danh sách
            const activeItem = document.querySelectorAll('.video-list-item')[index];
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        // Sự kiện click cho danh sách video
        document.querySelectorAll('.video-list-item').forEach((item, index) => {
            item.addEventListener('click', function() {
                changeVideo(index);
            });
        });
        
        // Sự kiện cho nút Previous/Next
        document.getElementById('prev-video').addEventListener('click', function() {
            if (currentVideoIndex > 0) {
                changeVideo(currentVideoIndex - 1);
            }
        });
        
        document.getElementById('next-video').addEventListener('click', function() {
            if (currentVideoIndex < videos.length - 1) {
                changeVideo(currentVideoIndex + 1);
            }
        });
        
        // Khởi tạo
        changeVideo(0);
        updateProgressUI();
        
        // Tự động đánh dấu video đã xem khi video kết thúc
        const iframe = document.getElementById('youtube-player');
        iframe.addEventListener('load', function() {
            // Có thể thêm YouTube API để theo dõi video completion
            // Hiện tại chỉ đánh dấu khi chuyển video
        });
    });

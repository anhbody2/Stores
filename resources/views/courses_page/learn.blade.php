@extends('entry')
@section('content')
<style>
    .video-player-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .video-player-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    
    .video-list {
        max-height: 500px;
        overflow-y: auto;
    }
    
    .video-list-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .video-list-item:hover {
        background-color: #f8f9fa;
    }
    
    .video-list-item.active {
        background-color: #e3f2fd;
        border-left: 4px solid #007bff;
    }
    
    .video-title {
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .video-duration {
        font-size: 12px;
        color: #6c757d;
    }
    
    .progress-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    .progress-circle.completed {
        background: #28a745;
        color: white;
    }
</style>

<main class="container py-4">
    <!-- Course Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('my.courses') }}">My Courses</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('course.show', $course->course_id) }}">{{ $course->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Learn</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h2 mb-2">{{ $course->name }}</h1>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge bg-primary">{{ $category_name }}</span>
                        <span class="badge bg-info">{{ $difficulty_name }}</span>
                        <span class="text-muted">
                            <i class="far fa-play-circle me-1"></i>
                            {{ $video_count }} videos
                        </span>
                    </div>
                </div>
                <a href="{{ route('my.courses') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to My Courses
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Video Player Section -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if(empty($videos))
                        <div class="text-center py-5">
                            <i class="fas fa-video-slash fa-4x text-muted mb-3"></i>
                            <h4>No videos available</h4>
                            <p class="text-muted">This course doesn't have any video content yet.</p>
                        </div>
                    @else
                        <!-- YouTube Video Player -->
                        <div id="video-player-container" class="video-player-container">
                            <iframe id="youtube-player" 
                                    src="https://www.youtube.com/embed/{{ $videos[0]['video_id'] ?? '' }}?rel=0&showinfo=0" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                        
                        <!-- Current Video Info -->
                        <div id="current-video-info" class="mt-3">
                            <h4 id="current-video-title">{{ $videos[0]['title'] ?? 'Video 1' }}</h4>
                            <p id="current-video-description" class="text-muted">
                                {{ $videos[0]['description'] ?? 'No description' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Course Description -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">About this course</h5>
                    <p>{{ $course->description }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-chart-line text-primary me-2"></i>
                                    <strong>Level:</strong> {{ $category_name }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <strong>Duration:</strong> {{ $course->time_average }} hours
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <strong>Enrolled:</strong> {{ number_format($course->enrolled) }} students
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-star text-warning me-2"></i>
                                    <strong>Rating:</strong> {{ number_format($course->rate, 1) }}/5.0
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Video List Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-list-ol me-2"></i>Course Content
                        <span class="badge bg-primary float-end">{{ $video_count }}</span>
                    </h5>
                </div>
                
                @if(!empty($videos))
                    <div class="video-list">
                        @foreach($videos as $index => $video)
                            @php
                                $videoId = is_array($video) ? ($video['video_id'] ?? $video['url'] ?? '') : $video;
                                $title = is_array($video) ? ($video['title'] ?? "Video " . ($index + 1)) : "Video " . ($index + 1);
                                $description = is_array($video) ? ($video['description'] ?? '') : '';
                                $duration = is_array($video) ? ($video['duration'] ?? '') : '';
                                
                                // Extract YouTube ID from URL if needed
                                if (filter_var($videoId, FILTER_VALIDATE_URL)) {
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoId, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                }
                            @endphp
                            
                            <div class="video-list-item {{ $index === 0 ? 'active' : '' }}" 
                                 data-video-id="{{ $videoId }}"
                                 data-video-title="{{ $title }}"
                                 data-video-description="{{ $description }}">
                                <div class="d-flex align-items-start">
                                    <div class="progress-circle {{ $index === 0 ? 'completed' : '' }}" 
                                         id="progress-{{ $index }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="video-title">{{ $title }}</div>
                                        @if($duration)
                                            <div class="video-duration">{{ $duration }}</div>
                                        @endif
                                    </div>
                                    @if($index === 0)
                                        <div class="text-success">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card-body text-center py-4">
                        <i class="fas fa-video text-muted fa-2x mb-3"></i>
                        <p class="text-muted mb-0">No videos in this course</p>
                    </div>
                @endif
                
                <!-- Progress Summary -->
               <!-- Progress Summary -->
<div class="card-footer bg-white border-top">
    <div class="d-flex justify-content-between align-items-center">
        <div class="w-100"> <!-- Thêm class w-100 để chiếm toàn bộ chiều rộng -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted">Your Progress</small>
                <span id="progress-text" class="fw-bold">0/{{ $video_count }}</span>
            </div>
            <!-- Thay đổi width của progress bar thành 100% -->
            <div class="progress" style="height: 10px;"> <!-- Tăng height cho dễ nhìn -->
                <div id="overall-progress" class="progress-bar bg-primary" style="width: 0%"></div>
            </div>
        </div>
    </div>
</div>
            
            <!-- Navigation Buttons -->
            @if(!empty($videos))
                <div class="mt-3 d-grid gap-2">
                    <button id="prev-video" class="btn btn-outline-primary" disabled>
                        <i class="fas fa-arrow-left me-2"></i>Previous Video
                    </button>
                    <button id="next-video" class="btn btn-primary">
                        Next Video<i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</main>

@if(!empty($videos))
<script>
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
</script>
@endif

@endsection
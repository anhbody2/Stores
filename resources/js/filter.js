console.log("Courses filter JS loaded (via Vite)");

const courseContainer = document.getElementById('course-container');
const categoryFilter = document.getElementById('categoryFilter');
const difficultyFilter = document.getElementById('difficultyFilter');
const searchInput = document.getElementById('searchInput');
const resetFiltersBtn = document.getElementById('resetFilters');
const resetEmptyBtn = document.getElementById('resetEmpty');
const emptyState = document.getElementById('empty-state');

let courses = window.courses || [];

// Function to get CSRF token
function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute('content') : '';
}

function filterCourses() {
    const selectedCategory = categoryFilter.value;
    const selectedDifficulty = difficultyFilter.value;
    const searchTerm = searchInput.value.trim().toLowerCase();

    const filteredCourses = courses.filter((course, index) => {
        if (selectedCategory !== "all" && String(course.category) !== String(selectedCategory)) {
            return false;
        }

        if (selectedDifficulty !== "all" && String(course.difficulty) !== String(selectedDifficulty)) {
            return false;
        }

        if (searchTerm) {
            if (!objectSearch(course, searchTerm)) {
                return false;
            }
        }

        console.log(" ✅ Match");
        return true;
    });

    renderCourses(filteredCourses);
    toggleEmptyState(filteredCourses.length === 0);
}
// Generic dynamic search across object fields
function objectSearch(obj, term) {
    return Object.values(obj).some(value =>
        String(value).toLowerCase().includes(term)
    );

}

// Render HTML
function renderCourses(list) {
    courseContainer.innerHTML = "";
    if (list.length === 0) {
        emptyState.classList.remove('d-none');
        courseContainer.classList.add('d-none');
        return;
    } else {
        emptyState.classList.add('d-none');
        courseContainer.classList.remove('d-none');
    }

    list.forEach(course => {
        const courseElement = document.createElement('div');
        courseElement.className = 'col';
        courseElement.innerHTML = `
            <a href="/course/${course.course_id}" class="text-decoration-none text-dark"> 
                <div class="card course-card h-100">
                <img src="${course.image}" class="card-img-top course-img" alt="${course.title}">
                
                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="d-none">
                            ${course.category}
                        </span>
                        <span class="badge bg-primary course-category">
                            ${course.category_name}
                        </span>

                        <span class="badge course-difficulty">
                            ${course.difficulty_name ?? ""}
                        </span>
                    </div>

                    <h5 class="card-title">${course.name}</h5>

                    <p class="card-text flex-grow-1">${course.description}</p>

                    <p class="card-text">
                        <i class="fa-solid fa-circle-user"></i> ${course.tutors}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div>
                            <span class="text-warning">${course.star_html}</span>
                            <span class="text-muted ms-1">${course.rate}</span>
                        </div>
                        <span class="course-duration">
                            <i class="fa-regular fa-clock"></i> ${course.time_average}h
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="course-price">$${course.price}</div>
                        <div class="text-muted small">
                            <i class="fa-solid fa-dove"></i> ${Number(course.enrolled).toLocaleString()} students
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <a href="/course/${course.course_id}" 
                           class="d-md-none d-block btn btn-sm btn-outline-primary me-md-2">View Details</a>
                        
                        <!-- Enroll Now Form - FIXED: Sử dụng onclick đơn giản -->
                        <form action="/course/${course.course_id}/enroll" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="${getCsrfToken()}">
                            <button type="submit" class="btn btn-sm btn-primary w-100 d-md-none d-block">
                                Enroll Now
                            </button>
                        </form>
                    </div>

                </div>
            </div>


            </a>
        `;

        courseContainer.appendChild(courseElement);
    });
}

window.filterByCategory = function (categoryId) {
    document.getElementById('categoryFilter').scrollIntoView({ behavior: 'smooth' });
    categoryFilter.value = categoryId;
    filterCourses();
}

// Empty-state handler
function toggleEmptyState(show) {
    emptyState.style.display = show ? "block" : "none";
}

// Reset filters
function resetFilters() {
    categoryFilter.value = "all";
    difficultyFilter.value = "all";
    searchInput.value = "";
    filterCourses();
}

// Event Listeners
if (categoryFilter) categoryFilter.addEventListener("change", filterCourses);
if (difficultyFilter) difficultyFilter.addEventListener("change", filterCourses);
if (searchInput) searchInput.addEventListener("input", filterCourses);
if (resetFiltersBtn) resetFiltersBtn.addEventListener("click", resetFilters);
if (resetEmptyBtn) resetEmptyBtn.addEventListener("click", resetFilters);

if (courses.length) {
    renderCourses(courses);
}

// Thêm global event listener cho confirm
document.addEventListener('submit', function (e) {
    if (e.target && e.target.matches('form[action*="/enroll"]')) {
        e.preventDefault();
        const form = e.target;
        const courseName = form.querySelector('.btn')?.textContent.includes('Enroll Now')
            ? 'this course'
            : 'Course';

        if (confirm(`Are you sure you want to enroll in ${courseName}?`)) {
            form.submit();
        }
    }
});
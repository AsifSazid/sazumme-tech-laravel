<x-frontend.layouts.master>

    <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-info">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="announcementLabel">📢 Announcement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column flex-md-row align-items-center" id="announcementBody">
                    {{-- Populated by JS --}}
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Hero Start -->
    <x-frontend.sections.welcome-section.hero-area />
    <!-- Hero End -->

    <!-- Service Start -->
    <x-frontend.sections.welcome-section.service />
    <!-- Service End -->

    <!-- About Start -->
    <x-frontend.sections.welcome-section.about />
    <!-- About End -->

    <!-- Counter Start -->
    {{-- <x-frontend.sections.welcome-section.counter /> --}}
    <!-- Counter End -->

    <!-- Choose Us Start -->
    <x-frontend.sections.welcome-section.choose-us />
    <!-- Choose Us End -->

    <!-- Skill Start -->
    {{-- <x-frontend.sections.welcome-section.skill /> --}}
    <!-- Skill End -->

    <!-- Testimonial Start  -->
    {{-- <x-frontend.sections.welcome-section.testimonials /> --}}
    <!-- Testimonial End  -->

    <!-- Team Start -->
    {{-- <x-frontend.sections.welcome-section.team /> --}}
    <!-- Team End -->

    <!-- Cta Start -->
    <x-frontend.layouts.partials.cta />
    <!-- Cta End -->


    <script>
        const allAnnouncements = @json($announcements);
        const shownAtKey = 'shownAnnouncementUUIDs';
        const hourLimit = 60 * 60 * 1000;
        const now = new Date().getTime();

        let shownData = JSON.parse(localStorage.getItem(shownAtKey)) || [];
        shownData = shownData.filter(item => now - item.time < hourLimit);
        const shownUUIDs = shownData.map(item => item.uuid);
        const remaining = allAnnouncements.filter(a => !shownUUIDs.includes(a.uuid));
        const toShow = remaining.slice(0, 2);

        function showNextAnnouncement(index = 0) {
            if (index >= toShow.length) return;

            const announcement = toShow[index];
            const modalElement = document.getElementById('announcementModal');
            const modalBody = document.getElementById('announcementBody');

            // Reset modal body content
            modalBody.innerHTML = '';

            // Construct new content
            const container = document.createElement('div');
            container.classList.add('text-center', 'p-3', 'w-100');

            if (announcement.image?.url) {
                const img = document.createElement('img');
                img.src = `/storage/${announcement.image.url}`;
                img.alt = announcement.title;
                img.classList.add('img-fluid', 'rounded', 'mb-2');
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
                container.appendChild(img);
            }

            const title = document.createElement('h5');
            title.textContent = announcement.title;
            title.classList.add('fw-bold', 'mb-1');
            container.appendChild(title);

            const body = document.createElement('p');
            body.innerHTML = announcement.body;
            body.classList.add('text-secondary', 'mb-0');
            container.appendChild(body);

            modalBody.appendChild(container);

            // Save shown to localStorage
            shownData.push({
                uuid: announcement.uuid,
                time: now
            });
            localStorage.setItem(shownAtKey, JSON.stringify(shownData));

            // Remove any previous event listener
            modalElement.removeEventListener('hidden.bs.modal', modalElement._modalHandler || (() => {}));

            // Add event to show next modal
            modalElement._modalHandler = function() {
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();
                showNextAnnouncement(index + 1);
            };

            modalElement.addEventListener('hidden.bs.modal', modalElement._modalHandler);

            // Actually show the modal
            const modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });

            modal.show();

            // Force re-center
            setTimeout(() => {
                modal._dialog?.classList?.add('modal-dialog-centered');
            }, 100);
        }

        window.addEventListener('load', () => {
            if (toShow.length > 0) {
                showNextAnnouncement(0);
            }
        });
    </script>


</x-frontend.layouts.master>

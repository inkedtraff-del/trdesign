document.addEventListener('DOMContentLoaded', () => {

    // УСКОРЕННАЯ анимация при скролле (теперь без долгого ожидания)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px" // Срабатывает чуть раньше
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const revealElements = document.querySelectorAll('.text-block, .image-block, .contact-info, .form-wrapper, .exhibition-item');
    
    revealElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)'; // Сократил дистанцию всплытия
        // Значительно ускорил: 0.6 секунд вместо 1.2, и задержка теперь минимальная
        el.style.transition = `all 0.6s cubic-bezier(0.25, 1, 0.5, 1) ${index * 0.05}s`;
        observer.observe(el);
    });

    // Обработка отправки формы
    const premiumForm = document.getElementById('premiumForm');
    if(premiumForm) {
        premiumForm.addEventListener('submit', (e) => {
            e.preventDefault(); 
            const btn = premiumForm.querySelector('.btn-editorial-dark');
            
            btn.textContent = 'Отправка...';
            btn.style.opacity = '0.5';
            
            setTimeout(() => {
                premiumForm.innerHTML = `
                    <div style="padding: 2rem 0;">
                        <h3 class="heading-serif" style="font-size: 2rem; margin-bottom: 1rem;">Благодарим.</h3>
                        <p class="body-text">Ваш запрос принят. Арт-директор свяжется с вами в ближайшее время для обсуждения деталей.</p>
                    </div>
                `;
            }, 800); // Тоже ускорил отбивку
        });
    }

    // Drag-to-scroll галереи
    const slider = document.querySelector('.exhibition-track');
    let isDown = false;
    let startX;
    let scrollLeft;

    if(slider) {
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.style.cursor = 'grabbing';
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2.5; // Чуть увеличил отзывчивость скролла
            slider.scrollLeft = scrollLeft - walk;
        });
    }
});
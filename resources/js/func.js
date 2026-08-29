/* funcionamento do card depoimento */
 const testimonials = [
            {
                text: '"A Mind Care transformou completamente a minha forma de lidar com o stress. Os profissionais são extremamente competentes e o ambiente é acolhedor."',
                author: 'Maria Silva'
            },
            {
                text: '"Excelente serviço! A equipa é muito atenciosa e os resultados superaram as minhas expectativas. Recomendo a todos."',
                author: 'João Santos'
            },
            {
                text: '"O acompanhamento psicológico que recebi foi fundamental para o meu desenvolvimento pessoal. Muito obrigado à equipa da Mind Care."',
                author: 'Maria Pedro'
            },
            {
                text: '"Depois de participar no Tratamento de Liderança da MindCare, a minha abordagem ao trabalho com a equipa mudou radicalmente. Aprendi a usar acordos diferentes ideias... Passei dar a ajudar a redirecionar nas tarefas domésticas."',
                author: 'Armando Pina'
            },
            {
                text: '"Profissionalismo e empatia definem a Mind Care. Sinto-me muito grato pelo apoio recebido durante todo o processo."',
                author: 'Carlos Mendes'
            }
        ];

        let currentIndex = 3;

        const testimonialText = document.getElementById('testimonialText');
        const authorName = document.getElementById('authorName');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dots = document.querySelectorAll('.dot');

        function updateTestimonial(index) {
            testimonialText.classList.add('fade-out');
            authorName.classList.add('fade-out');

            setTimeout(() => {
                testimonialText.textContent = testimonials[index].text;
                authorName.textContent = testimonials[index].author;
                
                testimonialText.classList.remove('fade-out');
                authorName.classList.remove('fade-out');
            }, 250);

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            currentIndex = index;
        }

        prevBtn.addEventListener('click', () => {
            const newIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
            updateTestimonial(newIndex);
        });

        nextBtn.addEventListener('click', () => {
            const newIndex = (currentIndex + 1) % testimonials.length;
            updateTestimonial(newIndex);
        });

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const index = parseInt(dot.getAttribute('data-index'));
                updateTestimonial(index);
            });
        });

      
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tabs').forEach(tabs__container => {
        const buttons = tabs__container.querySelectorAll('.tab__buttons button');
        const content__container = tabs__container.querySelector('.tab__content');
        const tabs = tabs__container.querySelectorAll('.tab__content .tab');

        buttons.forEach(button => {
            const target = document.querySelector(`.tab#${button.dataset.tab}`) || -1;

            button.addEventListener('click', () => {
                if (target === -1 || target.classList.contains('show')) return;

                buttons.forEach(button => {
                    button.classList.remove('show')

                    const elements = target.querySelectorAll('*');

                    elements.forEach(element => {
                        element.classList.remove('show');
                    });
                });
                tabs.forEach(tab => tab.classList.remove('show'));

                button.classList.add('show');
                content__container.style.minHeight = `${target.offsetHeight}px`;

                setTimeout(() => {
                    target.classList.add('show');

                    setTimeout(() => {
                        const elements = target.querySelectorAll('*');
                        let delay = 0;

                        elements.forEach(element => {
                            setTimeout(() => {
                                element.classList.add('show');
                            }, delay);
                            delay += 100;
                        });
                    }, 75);
                }, 300);
            });
        });

        setTimeout(() => {
            buttons[0].click();
        }, 1);
    });
});
const barContainer = document.querySelector('.bar-container');
const colors = ['#ff6b6b', '#f06595', '#74c0fc', '#ffa94d', '#69db7c'];

function createBars() {
    for (let i = 0; i < 100; i++) {
        const bar = document.createElement('div');
        bar.classList.add('bar');
        bar.style.backgroundColor = colors[i % colors.length];
        bar.style.animationDelay = `${i * 0.05}s`;
        barContainer.appendChild(bar);
    }
}

createBars();
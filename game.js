const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');

const box = 20; // Size of each grid cell
let snake = [{ x: 9 * box, y: 10 * box }]; // Initial snake position
let food = {
    x: Math.floor(Math.random() * (canvas.width / box)) * box,
    y: Math.floor(Math.random() * (canvas.height / box)) * box
};
let direction = null;
let score = 0;
let gameOver = false;

document.addEventListener('keydown', changeDirection);

function changeDirection(event) {
    if (event.key === 'ArrowUp' && direction !== 'DOWN') direction = 'UP';
    if (event.key === 'ArrowDown' && direction !== 'UP') direction = 'DOWN';
    if (event.key === 'ArrowLeft' && direction !== 'RIGHT') direction = 'LEFT';
    if (event.key === 'ArrowRight' && direction !== 'LEFT') direction = 'RIGHT';
}

function collision(newHead, snakeArray) {
    for (let segment of snakeArray) {
        if (newHead.x === segment.x && newHead.y === segment.y) return true;
    }
    return false;
}

function drawGame() {
    if (gameOver) return;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Draw the snake
    for (let segment of snake) {
        ctx.fillStyle = 'lime';
        ctx.fillRect(segment.x, segment.y, box, box);
        ctx.strokeStyle = 'black';
        ctx.strokeRect(segment.x, segment.y, box, box);
    }

    // Draw the food
    ctx.fillStyle = 'red';
    ctx.fillRect(food.x, food.y, box, box);

    // Draw score
    ctx.fillStyle = 'black';
    ctx.font = '20px Arial';
    ctx.fillText(`Score: ${score}`, 10, 20);

    // Move the snake
    let head = { x: snake[0].x, y: snake[0].y };

    if (direction === 'UP') head.y -= box;
    if (direction === 'DOWN') head.y += box;
    if (direction === 'LEFT') head.x -= box;
    if (direction === 'RIGHT') head.x += box;

    // Teleport snake if it crosses boundaries
    if (head.x < 0) head.x = canvas.width - box;
    if (head.x >= canvas.width) head.x = 0;
    if (head.y < 0) head.y = canvas.height - box;
    if (head.y >= canvas.height) head.y = 0;

    // Check if the snake eats the food
    if (head.x === food.x && head.y === food.y) {
        score++;
        food = {
            x: Math.floor(Math.random() * (canvas.width / box)) * box,
            y: Math.floor(Math.random() * (canvas.height / box)) * box
        };
    } else {
        snake.pop(); // Remove the tail
    }

    // Add new head
    snake.unshift(head);

    // Check for collisions
    if (collision(head, snake.slice(1))) {
        gameOver = true;
        alert(`Game Over! Your score: ${score}`);
        return;
    }
}

setInterval(drawGame, 100);
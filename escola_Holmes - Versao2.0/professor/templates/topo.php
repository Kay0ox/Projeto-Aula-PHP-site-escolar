<style>
header {
    background-color: #333;
    color: white;
    padding: 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
    animation: slideDown 0.5s ease;
}
header h1 {
    margin: 0;
    font-size: 32px;
    font-family: Arial, sans-serif;
}
header .user-info {
    margin-top: 10px;
    font-size: 16px;
}
@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<header>
    <div class="logo">
        <h1>Escola Holmes</h1>
    </div>
    <div class="user-info">
        <p>Bem-vindo, <?php echo $_SESSION['username']; ?>!</p>
    </div>
</header>

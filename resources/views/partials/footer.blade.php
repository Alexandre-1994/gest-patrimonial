<!-- resources/views/partials/footer.blade.php -->
<footer class="main-footer">
    <div class="footer-content">
        <div class="footer-section">
            <div class="footer-brand">
                <i class="fas fa-cube brand-icon"></i>
                <span class="brand-text">N’Kaya</span>
            </div>
            <div class="footer-meta">
                <span class="version">Versão 1.0.0</span>
                <span class="divider">•</span>
                <span class="company">TechCorp</span>
            </div>
        </div>

        <div class="footer-section">
            <div class="footer-links">
                <a href="#" class="footer-link">
                    <i class="fas fa-book"></i>
                    <span>Manual</span>
                </a>
                <a href="#" class="footer-link">
                    <i class="fas fa-question-circle"></i>
                    <span>Suporte</span>
                </a>
                <a href="#" class="footer-link">
                    <i class="fas fa-shield-alt"></i>
                    <span>Privacidade</span>
                </a>
            </div>
        </div>

        <div class="footer-section">
            <div class="footer-info">
                <p class="copyright">&copy; {{ date('Y') }} - Todos os direitos reservados</p>
                <div class="system-info">
                    <span class="server-time">
                        <i class="far fa-clock"></i>
                        <span id="server-time">{{ now()->format('H:i') }}</span>
                    </span>
                    <span class="divider">•</span>
                    <span class="user-count">
                        <i class="fas fa-users"></i>
                        <span>{{ Cache::get('active_users', 0) }} usuários ativos</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .main-footer {
        background: linear-gradient(to right, #1a237e, #0d47a1) !important;
        color: #ffffff !important;
        padding: 1rem 0 !important;
        position: fixed !important;
        bottom: 0 !important;
        width: 100% !important;
        z-index: 1000 !important;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1) !important;
    }

    .footer-content {
        max-width: 1400px !important;
        margin: 0 auto !important;
        padding: 0 1.5rem !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }

    .footer-section {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }

    .footer-section:nth-child(2) {
        align-items: center !important;
    }

    .footer-section:last-child {
        align-items: flex-end !important;
    }

    .footer-brand {
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        margin-bottom: 0.25rem !important;
    }

    .brand-icon {
        font-size: 1.25rem !important;
        color: #90caf9 !important;
    }

    .brand-text {
        font-weight: 600 !important;
        font-size: 0.9rem !important;
    }

    .footer-meta {
        font-size: 0.75rem !important;
        color: rgba(255, 255, 255, 0.7) !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }

    .footer-links {
        display: flex !important;
        gap: 1.5rem !important;
    }

    .footer-link {
        color: rgba(255, 255, 255, 0.9) !important;
        text-decoration: none !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        font-size: 0.85rem !important;
        transition: color 0.2s ease !important;
    }

    .footer-link:hover {
        color: #90caf9 !important;
    }

    .footer-link i {
        font-size: 0.9rem !important;
    }

    .footer-info {
        text-align: right !important;
    }

    .copyright {
        font-size: 0.8rem !important;
        margin-bottom: 0.25rem !important;
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .system-info {
        display: flex !important;
        align-items: center !important;
        gap: 0.75rem !important;
        font-size: 0.75rem !important;
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .server-time,
    .user-count {
        display: flex !important;
        align-items: center !important;
        gap: 0.35rem !important;
    }

    .divider {
        color: rgba(255, 255, 255, 0.4) !important;
    }

    @media (max-width: 991px) {
        .footer-content {
            flex-direction: column !important;
            gap: 1rem !important;
            text-align: center !important;
            padding: 1rem !important;
        }

        .footer-section {
            align-items: center !important;
        }

        .footer-section:last-child {
            align-items: center !important;
        }

        .footer-info {
            text-align: center !important;
        }

        .system-info {
            justify-content: center !important;
        }
    }

    @media (max-width: 576px) {
        .footer-links {
            flex-direction: column !important;
            gap: 0.75rem !important;
        }

        .system-info {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .divider {
            display: none !important;
        }
    }
</style>

<script>
    // Atualizar hora do servidor
    function updateServerTime() {
        const timeElement = document.getElementById('server-time');
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        timeElement.textContent = `${hours}:${minutes}`;
    }

    setInterval(updateServerTime, 60000); // Atualizar a cada minuto
</script>

<footer class="footer mt-5 py-5">
    <div class="container">
        <div class="row">
            <!-- Coluna da Marca/Logo -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-brand mb-3">
                    <i class="fas fa-tasks me-2"></i>XKanban Pro
                </div>
                <p class="text-muted mb-3">
                    Gerencie seus projetos de forma eficiente com nossa plataforma XKanban intuitiva e poderosa.
                </p>
                <div class="social-links">
                    <a href="#" class="social-icon" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-icon" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Coluna de Links Rápidos -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="mb-3">Navegação</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ url('/dashboard') }}">
                            <i class="fas fa-chevron-right me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#">
                            <i class="fas fa-chevron-right me-2"></i>Projetos
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#">
                            <i class="fas fa-chevron-right me-2"></i>Equipes
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#">
                            <i class="fas fa-chevron-right me-2"></i>Relatórios
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Coluna de Recursos -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="mb-3">Recursos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#">
                            <i class="fas fa-chevron-right me-2"></i>Documentação
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#">
                            <i class="fas fa-chevron-right me-2"></i>API
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#">
                            <i class="fas fa-chevron-right me-2"></i>Suporte
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#">
                            <i class="fas fa-chevron-right me-2"></i>Blog
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Coluna de Contato -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="mb-3">Contato</h5>
                <div class="contact-info">
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                        <span>Barcarena, Pará, Brasil</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <a href="mailto:contato@kanbanpro.com">contato@xkanbanpro.com</a>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-phone me-2 text-primary"></i>
                        <a href="tel:+5591999999999">+55 (91) 99999-9999</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Linha Divisória -->
        <hr class="footer-divider my-4">

        <!-- Copyright -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-muted">
                    &copy; {{ date('Y') }} XKanban Pro. Todos os direitos reservados.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="footer-links">
                    <a href="#" class="me-3">Política de Privacidade</a>
                    <a href="#" class="me-3">Termos de Uso</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

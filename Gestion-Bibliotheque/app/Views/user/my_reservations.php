<?= $this->extend('user/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Mes Réservations</h4>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Fonctionnalité de réservation à venir prochainement.
        </div>
        
        <div class="text-center py-4 py-md-5">
            <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
            <h5 class="mb-3">Bientôt disponible</h5>
            <p class="text-muted mb-4">Le système de réservation sera disponible dans une prochaine mise à jour.</p>
            <a href="<?= site_url('books') ?>" class="btn btn-primary">
                <i class="fas fa-book me-2"></i> Voir les livres disponibles
            </a>
        </div>

        <!-- Section d'information sur les futures réservations -->
        <div class="row mt-4">
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-clock text-primary fa-lg"></i>
                        </div>
                        <h6 class="card-title">Réservez à l'avance</h6>
                        <p class="card-text small text-muted">Garantissez votre accès aux livres les plus populaires</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-bell text-success fa-lg"></i>
                        </div>
                        <h6 class="card-title">Notifications</h6>
                        <p class="card-text small text-muted">Soyez alerté lorsque votre livre est disponible</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-calendar-alt text-info fa-lg"></i>
                        </div>
                        <h6 class="card-title">Gestion simple</h6>
                        <p class="card-text small text-muted">Visualisez et gérez toutes vos réservations</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-rotate-left text-warning fa-lg"></i>
                        </div>
                        <h6 class="card-title">Renouvellement</h6>
                        <p class="card-text small text-muted">Renouvelez vos réservations si nécessaire</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guide complet des réservations -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-book-open me-2"></i>Guide complet du système de réservation</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-1 me-2"></i>Comment réserver un livre</h6>
                                <p class="small text-muted mb-4">
                                    Lorsqu'un livre est actuellement emprunté, vous verrez un bouton "Réserver" à la place du bouton "Emprunter". 
                                    Cliquez dessus pour vous inscrire dans la file d'attente. Votre position dans la file sera indiquée clairement.
                                </p>
                                
                                <h6 class="text-primary mb-3"><i class="fas fa-2 me-2"></i>Notifications et alertes</h6>
                                <p class="small text-muted mb-4">
                                    Vous recevrez une notification par email et dans votre espace personnel lorsque le livre réservé sera disponible. 
                                    Vous aurez 48 heures pour venir le récupérer à la bibliothèque.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-3 me-2"></i>Gestion des réservations</h6>
                                <p class="small text-muted mb-4">
                                    Dans cette section, vous pourrez voir l'état de toutes vos réservations : en attente, disponible, ou annulée. 
                                    Vous pourrez également annuler une réservation à tout moment si vous n'en avez plus besoin.
                                </p>
                                
                                <h6 class="text-primary mb-3"><i class="fas fa-4 me-2"></i>Limites et règles</h6>
                                <p class="small text-muted">
                                    • Maximum 3 réservations simultanées<br>
                                    • Délai de 48 heures pour récupérer un livre disponible<br>
                                    • Réservations valables 14 jours maximum<br>
                                    • Possibilité de renouvellement selon disponibilité
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ sur les réservations -->
        <div class="row mt-5">
            <div class="col-12">
                <h5 class="mb-4"><i class="fas fa-question-circle me-2"></i>Questions fréquentes</h5>
                <div class="accordion" id="reservationFAQ">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="fas fa-question me-2"></i>Comment fonctionnera le système de réservation ?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#reservationFAQ">
                            <div class="accordion-body">
                                <p>Le système de réservation vous permet de "mettre de côté" un livre actuellement emprunté par un autre membre. Voici comment cela fonctionnera :</p>
                                <ol class="small">
                                    <li>Vous repérez un livre indisponible mais que vous souhaitez emprunter</li>
                                    <li>Vous cliquez sur le bouton "Réserver"</li>
                                    <li>Vous êtes placé dans une file d'attente selon l'ordre des réservations</li>
                                    <li>Lorsque le livre est retourné, le premier dans la file est notifié</li>
                                    <li>Vous avez 48 heures pour venir récupérer le livre à la bibliothèque</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="fas fa-clock me-2"></i>Combien de temps dure une réservation ?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#reservationFAQ">
                            <div class="accordion-body">
                                <p>Une réservation suit plusieurs étapes avec des délais précis :</p>
                                <ul class="small">
                                    <li><strong>En attente</strong> : La réservation reste active jusqu'à ce que le livre soit disponible</li>
                                    <li><strong>Disponible</strong> : Une fois le livre disponible, vous avez <strong>48 heures</strong> pour venir le récupérer</li>
                                    <li><strong>Expirée</strong> : Si vous ne récupérez pas le livre dans les délais, la réservation est annulée automatiquement</li>
                                    <li><strong>Durée maximale</strong> : Une réservation ne peut pas durer plus de 14 jours même si le livre n'est pas retourné</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="fas fa-list me-2"></i>Combien de réservations puis-je avoir ?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#reservationFAQ">
                            <div class="accordion-body">
                                <p>Pour garantir un accès équitable à tous les membres, les réservations sont soumises à certaines limites :</p>
                                <ul class="small">
                                    <li><strong>Maximum 3 réservations simultanées</strong> par membre</li>
                                    <li>Les réservations s'ajoutent à votre quota d'emprunts réguliers</li>
                                    <li>Vous ne pouvez pas réserver un livre que vous avez déjà emprunté récemment</li>
                                    <li>Les réservations sont personnelles et non transférables</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="fas fa-ban me-2"></i>Puis-je annuler une réservation ?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#reservationFAQ">
                            <div class="accordion-body">
                                <p>Oui, vous pourrez annuler une réservation à tout moment :</p>
                                <ul class="small">
                                    <li>Annulation possible depuis votre espace personnel</li>
                                    <li>Aucune pénalité pour annulation</li>
                                    <li>La place libérée est immédiatement offerte à la personne suivante dans la file d'attente</li>
                                    <li>Nous vous encourageons à annuler les réservations dont vous n'avez plus besoin pour permettre à d'autres membres d'en bénéficier</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                <i class="fas fa-exclamation-triangle me-2"></i>Que se passe-t-il si je ne récupère pas un livre réservé ?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#reservationFAQ">
                            <div class="accordion-body">
                                <p>Si vous ne récupérez pas un livre réservé dans les délais :</p>
                                <ul class="small">
                                    <li>La réservation est automatiquement annulée après 48 heures</li>
                                    <li>Le livre est proposé à la personne suivante dans la file d'attente</li>
                                    <li>Trop d'abandons de réservations pourraient limiter temporairement votre capacité à effectuer de nouvelles réservations</li>
                                    <li>Vous recevrez un rappel 24 heures avant l'expiration de votre délai</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline du processus -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-list-ol me-2"></i>Processus de réservation étape par étape</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon bg-primary">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>1. Recherche du livre</h6>
                                    <p class="small text-muted mb-0">Trouvez un livre actuellement emprunté que vous souhaitez réserver</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-success">
                                    <i class="fas fa-mouse-pointer"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>2. Réservation</h6>
                                    <p class="small text-muted mb-0">Cliquez sur "Réserver" et confirmez votre choix</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-info">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>3. File d'attente</h6>
                                    <p class="small text-muted mb-0">Vous êtes placé dans la file selon l'ordre d'arrivée</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-warning">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>4. Notification</h6>
                                    <p class="small text-muted mb-0">Recevez une alerte lorsque le livre est disponible</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-danger">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>5. Récupération</h6>
                                    <p class="small text-muted mb-0">Récupérez le livre à la bibliothèque sous 48 heures</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles responsives pour la page de réservation */
@media (max-width: 768px) {
    .card-header h4 {
        font-size: 1.25rem;
    }
    
    .alert {
        padding: 1rem;
    }
    
    .fa-3x {
        font-size: 2.5em;
    }
    
    .accordion-button {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
    
    .accordion-body {
        padding: 0.75rem 1rem;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }
    
    .text-center.py-4.py-md-5 {
        padding: 2rem 1rem !important;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .bg-opacity-10 {
        width: 50px !important;
        height: 50px !important;
    }
    
    .fa-lg {
        font-size: 1rem !important;
    }
    
    h5.mb-4 {
        font-size: 1.1rem;
        text-align: center;
    }
}

/* Animation pour les cartes d'information */
.card.text-center {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card.text-center:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

/* Style pour l'accordéon */
.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #0d6efd;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,.125);
}

/* Timeline style */
.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-icon {
    position: absolute;
    left: -3rem;
    top: 0;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.timeline-content {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    border-left: 3px solid #dee2e6;
}

.timeline-item:not(:last-child):after {
    content: '';
    position: absolute;
    left: -1.75rem;
    top: 2.5rem;
    bottom: -2rem;
    width: 2px;
    background: #dee2e6;
}

/* Responsive timeline */
@media (max-width: 768px) {
    .timeline {
        padding-left: 2.5rem;
    }
    
    .timeline-icon {
        left: -2.5rem;
        width: 2rem;
        height: 2rem;
        font-size: 0.8rem;
    }
    
    .timeline-item:not(:last-child):after {
        left: -1.5rem;
    }
}
</style>

<script>
// Animation pour le chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter une animation d'apparition progressive
    const cards = document.querySelectorAll('.card.text-center');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });

    // Animation pour la timeline
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 300 + (index * 200));
    });
});
</script>
<?= $this->endSection() ?>
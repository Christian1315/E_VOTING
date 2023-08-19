<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        #======== CREATION DES ACTIONS PAR DEFAUT=========#
        $actions = [
            [
                'name' => 'add_user',
                'description' => 'Ajout d\'utilisateur',
                'visible' => true
            ],
            [
                'name' => 'global_stats',
                'description' => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc.",
                'visible' => true
            ],
            [
                'name' => 'list_agency',
                'description' => 'Liste des distributeurs',
                'visible' => true
            ],
            [
                'name' => 'update_agency',
                'description' => 'Editer distribibuteur',
                'visible' => true
            ],
            [
                'name' => 'send_msg_to_distributor',
                'description' => 'Envoyer de message aux distributeur',
                'visible' => true
            ],
            [
                'name' => 'delete_agency',
                'description' => 'Supprimer distributeur',
                'visible' => true
            ],
            [
                'name' => 'add_user_right',
                'description' => 'Ajout de droit',
                'visible' => true
            ],
            [
                'name' => 'admin',
                'description' => 'Administration',
                'visible' => true
            ],
            [
                'name' => 'activate_card',
                'description' => 'Activation de carte',
                'visible' => true
            ],
            [
                'name' => 'admin_agency',
                'description' => 'Administration pour distributeur',
                'visible' => true
            ],
            [
                'name' => 'recharge_card',
                'description' => 'recharge de compte',
                'visible' => true
            ],
            [
                'name' => 'add_card',
                'description' => 'Ajout de carte',
                'visible' => true
            ],
            [
                'name' => 'add_agency',
                'description' => 'Ajouter distributeur',
                'visible' => true
            ],
            [
                'name' => 'add_pos',
                'description' => 'Ajouter Point de Service, agence pour les distributeur',
                'visible' => true
            ],
            [
                'name' => 'list_pos',
                'description' => 'Voir la liste des points de vente',
                'visible' => true
            ],
            [
                'name' => 'list_card',
                'description' => 'Lister les cartes',
                'visible' => true
            ],
            [
                'name' => 'add_agency',
                'description' => 'Ajouter une agence',
                'visible' => true
            ],
            [
                'name' => 'credit_agency',
                'description' => 'Créditer une agence',
                'visible' => true
            ],
            [
                'name' => 'add_card',
                'description' => 'Ajouter une carte',
                'visible' => true
            ],
            [
                'name' => 'list_agent',
                'description' => 'Lister des agents commerciaux',
                'visible' => true
            ],
            [
                'name' => 'add_agent',
                'description' => 'Ajouter agent commercial',
                'visible' => true
            ],
            [
                'name' => 'list_rechargement',
                'description' => 'Lister les rechargements',
                'visible' => true
            ],
            [
                'name' => 'validate_card_load',
                'description' => 'Valider rechargement de carte',
                'visible' => true
            ],
            [
                'name' => 'list_master',
                'description' => 'Lister des masters',
                'visible' => true
            ],
            [
                'name' => 'add_master',
                'description' => 'Ajouter des masters',
                'visible' => true
            ],
            [
                'name' => 'update_card',
                'description' => 'Ajouter des masters',
                'visible' => true
            ],
            [
                'name' => 'credit_my_account',
                'description' => 'Créditer mon compte',
                'visible' => true
            ],
            [
                'name' => 'add_card',
                'description' => 'Ajouter une carte',
                'visible' => true
            ],
            [
                'name' => 'debit_agency',
                'description' => 'Débiter une agence',
                'visible' => true
            ],
            [
                'name' => 'delete_card',
                'description' => 'Supprimer carte',
                'visible' => true
            ],
            [
                'name' => 'stats',
                'description' => 'Statistiques',
                'visible' => true
            ],
            [
                'name' => 'canal_renew',
                'description' => 'Ajouter renouvellement',
                'visible' => true
            ],
            [
                'name' => 'canal_validate_renew',
                'description' => 'Valider réabonnement',
                'visible' => true
            ],
            [
                'name' => 'add_decodeur',
                'description' => 'Ajouter décodeur',
                'visible' => true
            ],
            [
                'name' => 'credit_decodeur',
                'description' => 'Créditer le stock de décodeur pour un partenaire',
                'visible' => true
            ],
            [
                'name' => 'sell_decodeur',
                'description' => 'Vendre décodeur',
                'visible' => true
            ],
            [
                'name' => 'migrate_decodeur',
                'description' => 'Faire la migration de décodeur',
                'visible' => true
            ],
            [
                'name' => 'canal_validate_enroll',
                'description' => 'Valider les recrutements (vente de décodeur)',
                'visible' => true
            ],
            [
                'name' => 'debit_decodeur',
                'description' => 'Débiter décodeur',
                'visible' => true
            ],
            [
                'name' => 'canal_validate_migration',
                'description' => 'Valider les recrutements (vente de décodeur)',
                'visible' => true
            ],
            [
                'name' => 'list_decodeur',
                'description' => 'Liste décodeurs (recrutement)',
                'visible' => true
            ],
            [
                'name' => 'canal_renew',
                'description' => 'Réabonnement',
                'visible' => true
            ],
            [
                'name' => 'sell_decodeur',
                'description' => 'Recrutement (vente de décodeur)',
                'visible' => true
            ],
            [
                'name' => 'migrate_decodeur',
                'description' => 'Migration de décodeur',
                'visible' => true
            ],
            [
                'name' => 'credit_accessoires',
                'description' => 'Créditer accessoires',
                'visible' => true
            ],
            [
                'name' => 'credit_parabole',
                'description' => 'Créditer parabole',
                'visible' => true
            ],
            [
                'name' => 'debit_accessoires',
                'description' => 'Débiter accessoires',
                'visible' => true
            ],
            [
                'name' => 'end_operation',
                'description' => 'Finir une Opération',
                'visible' => true
            ],
            [
                'name' => 'canal_update',
                'description' => 'Modification abonnement canal',
                'visible' => true
            ],
            [
                'name' => 'canal_enroll',
                'description' => 'Recrutement canal',
                'visible' => true
            ],
            [
                'name' => 'list_enroll',
                'description' => 'Liste des recrutements',
                'visible' => true
            ],
            [
                'name' => 'credit_materiel',
                'description' => 'Créditer un matériel',
                'visible' => true
            ],
            [
                'name' => 'list_migration',
                'description' => 'Liste des miigration',
                'visible' => true
            ],
            [
                'name' => 'canal_migration',
                'description' => 'Faire des migrations',
                'visible' => true
            ],
            [
                'name' => 'add_stock',
                'description' => 'Ajouter stock',
                'visible' => true
            ],
            [
                'name' => 'list_renew',
                'description' => 'Liste des reabonnements',
                'visible' => true
            ],
            [
                'name' => 'list_reactivation',
                'description' => 'Lister les réactivations',
                'visible' => true
            ],
            [
                'name' => 'canal_reactivation',
                'description' => 'Réactivation',
                'visible' => true
            ],
            [
                'name' => 'delete_user_right',
                'description' => 'Retirer droit à un utilisateur',
                'visible' => true
            ],
            [
                'name' => 'deliver_card',
                'description' => 'Délivrer une carte',
                'visible' => true
            ],
            [
                'name' => 'card_validate_activation',
                'description' => 'Valider activation de carte',
                'visible' => true
            ],
            [
                'name' => 'deepsearch',
                'description' => 'Recherche approfondie',
                'visible' => true
            ],
            [
                'name' => 'list_deepsearch',
                'description' => 'Liste recherches approfondies',
                'visible' => true
            ],
            [
                'name' => 'set_deepsearch',
                'description' => 'Répondre recherches approfondies',
                'visible' => true
            ],
            [
                'name' => 'see_commission',
                'description' => 'Voir commission',
                'visible' => true
            ],
            [
                'name' => 'see_balance',
                'description' => 'Voir solde',
                'visible' => true
            ],
            [
                'name' => 'reset_user_pass',
                'description' => 'Réinitialiser mot de passe',
                'visible' => true
            ],
            [
                'name' => 'list_deposit',
                'description' => 'Liste des dépôts',
                'visible' => true
            ],
            [
                'name' => 'add_deposit',
                'description' => 'Ajouter des dépôts',
                'visible' => true
            ],
            [
                'name' => 'set_deposit',
                'description' => 'Valider des dépôts',
                'visible' => true
            ],
            [
                'name' => 'view_statement',
                'description' => 'Voir relevé de compte',
                'visible' => true
            ],
            [
                'name' => 'assurance_new',
                'description' => 'Ajouter assurance',
                'visible' => true
            ],
            [
                'name' => 'list_assurance',
                'description' => 'Lister assurance',
                'visible' => true
            ],
            [
                'name' => 'process_assurance',
                'description' => 'Dévis assurance',
                'visible' => true
            ],
            [
                'name' => 'approve_assurance',
                'description' => 'Approuver devis',
                'visible' => true
            ],
            [
                'name' => 'list_assurance',
                'description' => 'Liste assurance',
                'visible' => true
            ],
            [
                'name' => 'authorize_commission_withdrawal',
                'description' => 'Autoriser reversement de commission',
                'visible' => true
            ],
            [
                'name' => 'list_cardload',
                'description' => 'Liste rechargement carte',
                'visible' => true
            ],
            [
                'name' => 'facture_new',
                'description' => 'Emettre des factures',
                'visible' => true
            ],
            [
                'name' => 'list_facture',
                'description' => 'Liste des factures',
                'visible' => true
            ],
            [
                'name' => 'validate_facture',
                'description' => 'Valider des factures',
                'visible' => true
            ],
            [
                'name' => "list_master",
                'description' => "Lister les masters",
                'visible' => true
            ],
            [
                'name' => "add_master",
                'description' => "Ajouter un master",
                'visible' => true
            ],
            [
                'name' => "update_master",
                'description' => "Mettre à jour un master",
                'visible' => true
            ],
            [
                'name' => "delete_master",
                'description' => "Supprimer un master",
                'visible' => true
            ],
            [
                'name' => "list_agency",
                'description' => "Lister les agencies",
                'visible' => true
            ],
            [
                'name' => "add_agency",
                'description' => "Ajouter un agency",
                'visible' => true
            ],
            [
                'name' => "update_agency",
                'description' => "Mettre à jour un agency",
                'visible' => true
            ],
            [
                'name' => "delete_agency",
                'description' => "Supprimer un agency",
                'visible' => true
            ],
            [
                'name' => "list_agent",
                'description' => "Lister les agents",
                'visible' => true
            ],
            [
                'name' => "add_agent",
                'description' => "Ajouter un agent",
                'visible' => true
            ],
            [
                'name' => "update_agent",
                'description' => "Mettre à jour un agent",
                'visible' => true
            ],
            [
                'name' => "delete_agent",
                'description' => "Supprimer un agent",
                'visible' => true
            ],
            [
                'name' => "list_pos",
                'description' => "Lister les pos",
                'visible' => true
            ],
            [
                'name' => "add_pos",
                'description' => "Ajouter un pos",
                'visible' => true
            ],
            [
                'name' => "update_pos",
                'description' => "Mettre à jour un pos",
                'visible' => true
            ],
            [
                'name' => "delete_pos",
                'description' => "Supprimer un pos",
                'visible' => true
            ],
            [
                'name' => "list_table",
                'description' => "Lister les tables",
                'visible' => true
            ],
            [
                'name' => "add_table",
                'description' => "Ajouter une table",
                'visible' => true
            ],
            [
                'name' => "update_table",
                'description' => "Mettre à jour une table",
                'visible' => true
            ],
            [
                'name' => "delete_table",
                'description' => "Supprimer une table",
                'visible' => true
            ],
            [
                'name' => "list_product",
                'description' => "Lister les products",
                'visible' => true
            ],
            [
                'name' => "add_product",
                'description' => "Ajouter un product",
                'visible' => true
            ],
            [
                'name' => "update_product",
                'description' => "Mettre à jour un product",
                'visible' => true
            ],
            [
                'name' => "delete_product",
                'description' => "Supprimer un product",
                'visible' => true
            ],
            [
                'name' => "list_order",
                'description' => "Lister les orders",
                'visible' => true
            ],
            [
                'name' => "add_order",
                'description' => "Ajouter un order",
                'visible' => true
            ],
            [
                'name' => "update_order",
                'description' => "Mettre à jour un order",
                'visible' => true
            ],
            [
                'name' => "delete_order",
                'description' => "Supprimer un order",
                'visible' => true
            ],
            [
                'name' => "list_product_category",
                'description' => "Lister les product_categories",
                'visible' => true
            ],
            [
                'name' => "add_product_category",
                'description' => "Ajouter un product_category",
                'visible' => true
            ],
            [
                'name' => "update_product_category",
                'description' => "Mettre à jour un product_category",
                'visible' => true
            ],
            [
                'name' => "delete_product_category",
                'description' => "Supprimer un product_category",
                'visible' => true
            ],
            [
                'name' => "list_store",
                'description' => "Lister les stores",
                'visible' => true
            ],
            [
                'name' => "add_store",
                'description' => "Ajouter un store",
                'visible' => true
            ],
            [
                'name' => "update_store",
                'description' => "Mettre à jour un store",
                'visible' => true
            ],
            [
                'name' => "delete_store",
                'description' => "Supprimer un store",
                'visible' => true
            ],
            [
                'name' => "list_user",
                'description' => "Lister les users",
                'visible' => true
            ],
            [
                'name' => "update_user",
                'description' => "Mettre à jour un user",
                'visible' => true
            ],
            [
                'name' => "delete_user",
                'description' => "Supprimer un user",
                'visible' => true
            ],
            [
                'name' => "list_right",
                'description' => "Lister les rights",
                'visible' => true
            ],
            [
                'name' => "add_right",
                'description' => "Ajouter un right",
                'visible' => true
            ],
            [
                'name' => "update_right",
                'description' => "Mettre à jour un right",
                'visible' => true
            ],
            [
                'name' => "delete_right",
                'description' => "Supprimer un right",
                'visible' => true
            ],
            [
                'name' => "list_profil",
                'description' => "Lister les profils",
                'visible' => true
            ],
            [
                'name' => "add_profil",
                'description' => "Ajouter un profil",
                'visible' => true
            ],
            [
                'name' => "update_profil",
                'description' => "Mettre à jour un profil",
                'visible' => true
            ],
            [
                'name' => "delete_profil",
                'description' => "Supprimer un profil",
                'visible' => true
            ],
            [
                'name' => "list_rang",
                'description' => "Lister les rangs",
                'visible' => true
            ],
            [
                'name' => "add_rang",
                'description' => "Ajouter un rang",
                'visible' => true
            ],
            [
                'name' => "update_rang",
                'description' => "Mettre à jour un rang",
                'visible' => true
            ],
            [
                'name' => "delete_rang",
                'description' => "Supprimer un rang",
                'visible' => true
            ],
            [
                'name' => "list_action",
                'description' => "Lister les action",
                'visible' => true
            ],
            [
                'name' => "add_action",
                'description' => "Ajouter un action",
                'visible' => true
            ],
            [
                'name' => "update_action",
                'description' => "Mettre à jour un action",
                'visible' => true
            ],
            [
                'name' => "delete_action",
                'description' => "Supprimer un action",
                'visible' => true
            ],
            [
                'name' => "affect_right",
                'description' => "Affecter un droit",
                'visible' => true
            ]
        ];

        foreach ($actions as $action) {
            \App\Models\Action::factory()->create($action);
        }

        #======== CREATION DES PROFILS PAR DEFAUT=========#
        $profils = [
            [
                "name" => "Système",
                "description" => "Gestionnaire du Système",
            ],
            [
                "name" => "Responsable",
                "description" => "Le Responsable du compte",
            ],
            [
                "name" => "Technicien",
                "description" => "Un Technicien de votre structure ou de FRIKLABEL",
            ],
            [
                "name" => "Employe",
                "description" => "Un Employe de votre structure",
            ],
            [
                "name" => "Agency",
                "description" => "Un Distributeur de votre structure",
            ],
            [
                "name" => "Master",
                "description" => "Master distributeur",
            ],
            [
                "name" => "Agent",
                "description" => "Agent commercial",
            ],
            [
                "name" => "Client",
                "description" => "Client",
            ],
            [
                "name" => "Admin",
                "description" => "L'administrateur",
            ],
        ];

        foreach ($profils as $profil) {
            \App\Models\Profil::factory()->create($profil);
        }

        #======== CREATION DES RANGS PAR DEFAUT=========#

        $rangs = [
            [
                "name" => "admin",
                "description" => "L'administrateur général du networking",
            ],
            [
                "name" => "moderator",
                "description" => "Le modérateur du compte",
            ],
            [
                "name" => "user",
                "description" => "Un simple utilisateur du compte",
            ],
        ];

        foreach ($rangs as $rang) {
            \App\Models\Rang::factory()->create($rang);
        }

        #======== CREATION DES RIGHTS  PAR DEFAUT =========#
        $rights = [
            ##### add_user
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout d'utilisateur"
            ],
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout d'utilisateur"
            ],
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajout d'utilisateur"
            ],
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajout d'utilisateur"
            ],


            ######## global_stats

            [
                "action" => \App\Models\Action::find(2),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc."
            ],
            [
                "action" => \App\Models\Action::find(2),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc."
            ],
            [
                "action" => \App\Models\Action::find(2),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc."
            ],

            ######## list_agency

            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(7),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des distributeurs"
            ],

            ######## update_agency

            [
                "action" => \App\Models\Action::find(4),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Editer distribibuteur"
            ],
            [
                "action" => \App\Models\Action::find(4),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Editer distribibuteur"
            ],
            [
                "action" => \App\Models\Action::find(4),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Editer distribibuteur"
            ],

            ######## send_msg_to_distributor

            [
                "action" => \App\Models\Action::find(5),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Envoyer de message aux distributeur"
            ],
            [
                "action" => \App\Models\Action::find(5),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Envoyer de message aux distributeur"
            ],
            [
                "action" => \App\Models\Action::find(5),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Envoyer de message aux distributeur"
            ],

            ######## delete_agency

            [
                "action" => \App\Models\Action::find(6),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Supprimer distributeur"
            ],
            [
                "action" => \App\Models\Action::find(6),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Supprimer distributeur"
            ],
            [
                "action" => \App\Models\Action::find(6),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Supprimer distributeur"
            ],

            ######## add_user_right

            [
                "action" => \App\Models\Action::find(7),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout de droit"
            ],
            [
                "action" => \App\Models\Action::find(7),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajout de droit"
            ],
            [
                "action" => \App\Models\Action::find(7),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout de droit"
            ],

            ######## admin

            [
                "action" => \App\Models\Action::find(8),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Administration"
            ],
            [
                "action" => \App\Models\Action::find(8),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Administration"
            ],

            ######## activate_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Activation de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Activation de compte"
            ],

            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Activation de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de compte"
            ],


            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de carte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de carte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Activer compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(7),
                "description" => "Activer compte"
            ],



            ######## recharge_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "recharge de compte"
            ],

            ######## add_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(12),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajout de carte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(12),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajouter. compte carte prépayée"
            ],

            ######## add_agency

            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajouter distributeur"
            ],

            ######## add_pos

            [
                "action" => \App\Models\Action::find(14),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Ajouter Point de Service, agence pour les distributeur"
            ],

            ######## list_pos

            [
                "action" => \App\Models\Action::find(15),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Voir la liste des points de vente"
            ],
            [
                "action" => \App\Models\Action::find(15),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des points de service"
            ],
            [
                "action" => \App\Models\Action::find(15),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des points de service"
            ],


            ######## list_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des cartes"
            ],


            ######## add_agency

            [
                "action" => \App\Models\Action::find(17),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(17),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter distributeur"
            ],


            ######## credit_agency

            [
                "action" => \App\Models\Action::find(18),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer distributeur"
            ],
            [
                "action" => \App\Models\Action::find(18),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer distributeur"
            ],


            ######## add_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(19),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajout de carte"
            ],

            ######## list_agent

            [
                "action" => \App\Models\Action::find(20),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des agents commerciaux"
            ],

            ######## add_agent

            [
                "action" => \App\Models\Action::find(21),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter agent commercial"
            ],


            ######## list_rechargement

            [
                "module" => 2,
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste les rechargements"
            ],
            [
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Liste les rechargements"
            ],
            [
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Liste les rechargements"
            ],
            [
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste les rechargements"
            ],

            ######## validate_card_load

            [
                "module" => 1,
                "action" => \App\Models\Action::find(23),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider rechargement de carte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(23),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider rechargement"
            ],


            ######## list_master

            [
                "action" => \App\Models\Action::find(24),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "List des masters"
            ],

            ######## add_master

            [
                "action" => \App\Models\Action::find(25),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajout de master"
            ],

            ######## update_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(26),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Modifier compte"
            ],


            ######## credit_my_account

            [
                "action" => \App\Models\Action::find(27),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer mon compte"
            ],

            ######## add_card

            [
                "action" => \App\Models\Action::find(28),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajout de cartes"
            ],

            ######## debit_agency

            [
                "action" => \App\Models\Action::find(29),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Débiter une agence"
            ],
            [
                "action" => \App\Models\Action::find(29),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Débiter une agence"
            ],



            ######## delete_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(30),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Supprimer carte"
            ],

            ######## stats

            [
                "action" => \App\Models\Action::find(31),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Statistiques"
            ],

            ######## canal_renew

            [
                "module" => 2,
                "action" => \App\Models\Action::find(32),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Ajouter renouvellement"
            ],

            ######## canal_validate_renew

            [
                "module" => 2,
                "action" => \App\Models\Action::find(33),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider réabonnement"
            ],

            ######## add_decodeur

            [
                "module" => 2,
                "action" => \App\Models\Action::find(34),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter décodeur"
            ],

            ######## credit_decodeur

            [
                "module" => 2,
                "action" => \App\Models\Action::find(35),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer le stock de décodeur pour un partenaire"
            ],

            ######## sell_decodeur

            [
                "module" => 2,
                "action" => \App\Models\Action::find(36),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Vendre décodeur"
            ],

            ######## migrate_decodeur

            [
                "module" => 2,
                "action" => \App\Models\Action::find(37),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Faire la migration de décodeur"
            ],

            ######## canal_validate_enroll

            [
                "module" => 2,
                "action" => \App\Models\Action::find(38),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider les recrutements (vente de décodeur)"
            ],

            ######## debit_decodeur

            [
                "module" => 2,
                "action" => \App\Models\Action::find(39),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Débiter décodeur"
            ],

            ######## canal_validate_migration

            [
                "module" => 2,
                "action" => \App\Models\Action::find(40),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider les recrutements (vente de décodeur)"
            ],
            ####### NB::::: JE ME SUIS ARRETER ICI AU DROIT 104 DE LA DB DE MR JOEL

            ["action" => \App\Models\Action::find(137), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Affecter un droit"],
            ["action" => \App\Models\Action::find(136), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un action"],
            ["action" => \App\Models\Action::find(135), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un action"],
            ["action" => \App\Models\Action::find(134), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un action"],
            ["action" => \App\Models\Action::find(133), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les action"],
            ["action" => \App\Models\Action::find(132), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un rang"],
            ["action" => \App\Models\Action::find(131), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un rang"],
            ["action" => \App\Models\Action::find(130), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un rang"],
            ["action" => \App\Models\Action::find(129), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les rangs"],
            ["action" => \App\Models\Action::find(128), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un profil"],
            ["action" => \App\Models\Action::find(127), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un profil"],
            ["action" => \App\Models\Action::find(126), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un profil"],
            ["action" => \App\Models\Action::find(125), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les profils"],
            ["action" => \App\Models\Action::find(124), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un right"],
            ["action" => \App\Models\Action::find(123), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un right"],
            ["action" => \App\Models\Action::find(122), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un right"],
            ["action" => \App\Models\Action::find(121), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les rights"],
            ["action" => \App\Models\Action::find(120), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un user"],
            ["action" => \App\Models\Action::find(119), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un user"],
            ["action" => \App\Models\Action::find(118), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les users"],
            ["action" => \App\Models\Action::find(117), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un store"],
            ["action" => \App\Models\Action::find(116), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un store"],
            ["action" => \App\Models\Action::find(115), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un store"],
            ["action" => \App\Models\Action::find(114), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les stores"],
            ["action" => \App\Models\Action::find(113), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un product_category"],
            ["action" => \App\Models\Action::find(112), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un product_category"],
            ["action" => \App\Models\Action::find(111), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un product_category"],
            ["action" => \App\Models\Action::find(110), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les product_categories"],
            ["action" => \App\Models\Action::find(109), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un order"],
            ["action" => \App\Models\Action::find(108), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un order"],
            ["action" => \App\Models\Action::find(107), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un order"],
            ["action" => \App\Models\Action::find(106), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les orders"],
            ["action" => \App\Models\Action::find(105), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un product"],
            ["action" => \App\Models\Action::find(104), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un product"],
            ["action" => \App\Models\Action::find(103), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un product"],
            ["action" => \App\Models\Action::find(102), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les products"],
            ["action" => \App\Models\Action::find(101), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer une table"],
            ["action" => \App\Models\Action::find(100), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour une table"],
            ["action" => \App\Models\Action::find(99), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter une table"],
            ["action" => \App\Models\Action::find(98), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les tables"],
            ["action" => \App\Models\Action::find(97), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un pos"],
            ["action" => \App\Models\Action::find(96), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un pos"],
            ["action" => \App\Models\Action::find(95), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un pos"],
            ["action" => \App\Models\Action::find(94), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les pos"],
            ["action" => \App\Models\Action::find(93), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un agent"],
            ["action" => \App\Models\Action::find(92), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un agent"],
            ["action" => \App\Models\Action::find(91), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un agent"],
            ["action" => \App\Models\Action::find(90), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les agents"],
            ["action" => \App\Models\Action::find(89), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un agency"],
            ["action" => \App\Models\Action::find(88), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un agency"],
            ["action" => \App\Models\Action::find(87), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un agency"],
            ["action" => \App\Models\Action::find(86), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les agencies"],
            ["action" => \App\Models\Action::find(85), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Supprimer un master"],
            ["action" => \App\Models\Action::find(84), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Mettre à jour un master"],
            ["action" => \App\Models\Action::find(83), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Ajouter un master"],
            ["action" => \App\Models\Action::find(82), "rang" => \App\Models\Rang::find(1), "profil" => \App\Models\Profil::find(9), "description" => "Lister les masters"]
        ];

        foreach ($rights as $right) {
            \App\Models\Right::factory()->create($right);
        }


        $users = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$CI5P59ICr/HOihqlnYUrLeKwCajgMKd34HB66.JsJBrIOQY9fazrG', #admin
                'is_super_admin' => true,
                'phone' => "22961765591",
                "rang_id" => \App\Models\Rang::find(1),
                "profil_id" => \App\Models\Profil::find(9),
            ],
            [
                'name' => 'Joel PPJ',
                'username' => 'ppjjoel',
                'email' => 'ppjjoel@gmail.com',
                'password' => '$2y$10$ZT2msbcfYEUWGUucpnrHwekWMBDe1H0zGrvB.pzQGpepF8zoaGIMC', #ppjjoel
                'is_super_admin' => true,
                'phone' => "22961765592",
                "rang_id" => \App\Models\Rang::find(1),
                "profil_id" => \App\Models\Profil::find(9),
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::factory()->create($user);
        }

        ###========CREATION DES STATUS DE VOTE PAR DEFAUT ==========###
        $vote_status = [
            [
                'name' => 'En Attente',
            ],
            [
                'name' => 'En Cour',
            ],
            [
                'name' => 'Terminé',
            ],
            [
                'name' => 'Annulé',
            ],
        ];

        foreach ($vote_status as $status) {
            \App\Models\VoteStatus::factory()->create($status);
        }
    }
}

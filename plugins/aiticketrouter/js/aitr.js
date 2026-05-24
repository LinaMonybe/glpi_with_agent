/**
 * AI Ticket Router - Version avec tous les boutons alignés à droite
 */
(function() {
    'use strict';
    
    console.log('[AITR] Version 5.0 - Boutons regroupés à droite');
    
    // Fonction pour trouver le champ GLPI spécifique
    function findGLPIField(field) {
        const fieldNames = {
            'urgency': ['urgency', 'urgency_id', 'ticket[urgency]', 'ticket[urgency_id]', 'dropdown_urgency_id'],
            'impact': ['impact', 'impact_id', 'ticket[impact]', 'ticket[impact_id]', 'dropdown_impact_id'],
            'priority': ['priority', 'priority_id', 'ticket[priority]', 'ticket[priority_id]', 'dropdown_priority_id']
        };
        
        const namesToTry = fieldNames[field] || [field, field + '_id'];
        
        for (let name of namesToTry) {
            let element = document.querySelector('select[name="' + name + '"]');
            if (element) return element;
            
            element = document.querySelector('input[name="' + name + '"]');
            if (element) return element;
            
            element = document.getElementById(name);
            if (element) return element;
        }
        
        let allInputs = document.querySelectorAll('select, input');
        for (let el of allInputs) {
            let name = el.name || '';
            let id = el.id || '';
            if (name.toLowerCase().includes(field) || id.toLowerCase().includes(field)) {
                return el;
            }
        }
        
        return null;
    }
    
    // Fonction pour appliquer la valeur
    function applySingleField(field, value, btnElement) {
        console.log('[AITR] Application', field, '=', value);
        
        let originalText = btnElement ? btnElement.innerHTML : '';
        let originalBg = btnElement ? btnElement.style.backgroundColor : '';
        
        if (btnElement) {
            btnElement.innerHTML = '⏳...';
            btnElement.disabled = true;
        }
        
        let targetElement = findGLPIField(field);
        
        if (!targetElement) {
            if (btnElement) {
                btnElement.innerHTML = '❌';
                btnElement.style.backgroundColor = '#dc3545';
                setTimeout(() => {
                    btnElement.innerHTML = originalText;
                    btnElement.style.backgroundColor = originalBg;
                    btnElement.disabled = false;
                }, 2000);
            }
            return false;
        }
        
        let success = false;
        try {
            if (targetElement.tagName === 'SELECT') {
                let optionExists = false;
                for (let i = 0; i < targetElement.options.length; i++) {
                    if (targetElement.options[i].value == value) {
                        targetElement.selectedIndex = i;
                        optionExists = true;
                        break;
                    }
                }
                
                if (!optionExists) {
                    let newOption = new Option(value.toString(), value);
                    targetElement.add(newOption);
                    targetElement.value = value;
                }
                
                targetElement.value = value;
                success = true;
                
            } else if (targetElement.tagName === 'INPUT') {
                targetElement.value = value;
                success = true;
            }
            
            if (success) {
                targetElement.dispatchEvent(new Event('change', { bubbles: true }));
                targetElement.dispatchEvent(new Event('input', { bubbles: true }));
                if (typeof $ !== 'undefined') {
                    $(targetElement).trigger('change');
                }
            }
            
        } catch(e) {
            success = false;
        }
        
        if (btnElement) {
            if (success) {
                btnElement.innerHTML = '✓';
                btnElement.style.backgroundColor = '#198754';
                setTimeout(() => {
                    btnElement.innerHTML = originalText;
                    btnElement.style.backgroundColor = originalBg;
                    btnElement.disabled = false;
                }, 1500);
            } else {
                btnElement.innerHTML = '❌';
                btnElement.style.backgroundColor = '#dc3545';
                setTimeout(() => {
                    btnElement.innerHTML = originalText;
                    btnElement.style.backgroundColor = originalBg;
                    btnElement.disabled = false;
                }, 2000);
            }
        }
        
        return success;
    }
    
    // Fonction pour créer les 3 boutons regroupés à droite
    function createButtonsGroup(urgencyValue, impactValue, priorityValue) {
        // Conteneur principal des boutons
        const container = document.createElement('div');
        container.style.cssText = 'display:flex; flex-direction:column; gap:8px; align-items:center; justify-content:center;';
        
        // Bouton Urgence
        const btnUrgency = document.createElement('button');
        btnUrgency.innerHTML = '✔ Appliquer';
        btnUrgency.className = 'aitr-custom-btn aitr-btn-urgency';
        btnUrgency.setAttribute('data-field', 'urgency');
        btnUrgency.setAttribute('data-value', urgencyValue);
        btnUrgency.style.cssText = 'padding:6px 15px; background:#4a6cf7; color:#fff; border-radius:6px; cursor:pointer; font-size:12px; font-weight:bold; border:none; transition:all 0.2s; width:100%; min-width:140px;';
        
        // Bouton Impact
        const btnImpact = document.createElement('button');
        btnImpact.innerHTML = '✔ Appliquer';
        btnImpact.className = 'aitr-custom-btn aitr-btn-impact';
        btnImpact.setAttribute('data-field', 'impact');
        btnImpact.setAttribute('data-value', impactValue);
        btnImpact.style.cssText = 'padding:6px 15px; background:#4a6cf7; color:#fff; border-radius:6px; cursor:pointer; font-size:12px; font-weight:bold; border:none; transition:all 0.2s; width:100%; min-width:140px;';
        
        // Bouton Priorité
        const btnPriority = document.createElement('button');
        btnPriority.innerHTML = '✔ Appliquer';
        btnPriority.className = 'aitr-custom-btn aitr-btn-priority';
        btnPriority.setAttribute('data-field', 'priority');
        btnPriority.setAttribute('data-value', priorityValue);
        btnPriority.style.cssText = 'padding:6px 15px; background:#4a6cf7; color:#fff; border-radius:6px; cursor:pointer; font-size:12px; font-weight:bold; border:none; transition:all 0.2s; width:100%; min-width:140px;';
        
        // Ajouter les événements
        btnUrgency.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            applySingleField('urgency', urgencyValue, this);
        });

        
        btnImpact.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            applySingleField('impact', impactValue, this);
        });
        
        btnPriority.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            applySingleField('priority', priorityValue, this);
        });
        
        container.appendChild(btnUrgency);
        container.appendChild(btnImpact);
        container.appendChild(btnPriority);
        
        return container;
    }
    
    // Fonction principale pour ajouter la colonne des boutons à droite
    function addButtonsColumnToRight() {
        console.log('[AITR] Ajout de la colonne des boutons à droite...');
        
        // Chercher les valeurs
        let urgencyValue = null;
        let impactValue = null;
        let priorityValue = null;
        let targetRow = null;
        
        const rows = document.querySelectorAll('tr');
        
        for (let row of rows) {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 2) {
                const labelCell = cells[0];
                const valueCell = cells[1];
                const labelText = (labelCell.innerText || '').toLowerCase();
                const valueText = valueCell.innerText || '';
                const match = valueText.match(/(\d+)\/5/);
                
                if (match) {
                    const value = match[1];
                    
                    if (labelText.includes('urgence')) {
                        urgencyValue = value;
                        targetRow = row;
                    } else if (labelText.includes('impact')) {
                        impactValue = value;
                    } else if (labelText.includes('priorité') || labelText.includes('priorite')) {
                        priorityValue = value;
                    }
                }
            }
        }
        
        if (urgencyValue && impactValue && priorityValue && targetRow) {
            // Vérifier si la colonne existe déjà
            const existingColumn = targetRow.parentNode.querySelector('.aitr-buttons-column');
            if (existingColumn) {
                console.log('[AITR] Colonne déjà présente');
                return;
            }
            
            // Créer le groupe de boutons
            const buttonsGroup = createButtonsGroup(urgencyValue, impactValue, priorityValue);
            
            // Pour chaque ligne des 3 champs, ajouter une cellule avec rowspan
            const urgencyRow = targetRow;
            const impactRow = targetRow.nextElementSibling;
            const priorityRow = impactRow ? impactRow.nextElementSibling : null;
            
            if (urgencyRow && impactRow && priorityRow) {
                // Créer une nouvelle cellule dans la première ligne avec rowspan=3
                const newCell = document.createElement('td');
                newCell.className = 'aitr-buttons-column';
                newCell.setAttribute('rowspan', '3');
                newCell.style.cssText = 'padding:7px 12px; border-top:1px solid #dee2e6; vertical-align:middle; text-align:center; background:#fff; width:160px;';
                newCell.appendChild(buttonsGroup);
                
                // Ajouter la cellule à la fin de la ligne
                urgencyRow.appendChild(newCell);
                
                // Ajouter des cellules vides sur les autres lignes pour garder l'alignement
                const emptyCell = document.createElement('td');
                emptyCell.style.cssText = 'padding:7px 12px; border-top:1px solid #dee2e6; vertical-align:middle; background:#fff;';
                emptyCell.style.display = 'none';
                
                console.log('[AITR] ✅ Colonne des boutons ajoutée à droite avec rowspan=3');
            }
        } else {
            console.log('[AITR] En attente des valeurs...', {urgencyValue, impactValue, priorityValue});
            setTimeout(() => addButtonsColumnToRight(), 500);
        }
    }
    
    // Version alternative : boutons individuels alignés à droite
    function addIndividualButtonsToRight() {
        console.log('[AITR] Ajout des boutons individuels à droite...');
        
        const rows = document.querySelectorAll('tr');
        let buttonsAdded = 0;
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 2) {
                const labelCell = cells[0];
                const valueCell = cells[1];
                const labelText = (labelCell.innerText || '').toLowerCase();
                
                let field = null;
                let buttonText = '';
                
              
                
                if (field && !valueCell.querySelector('.aitr-custom-btn')) {
                    const valueText = valueCell.innerText || '';
                    const match = valueText.match(/(\d+)\/5/);
                    
                    if (match) {
                        const value = match[1];
                        
                        const button = document.createElement('button');
                        button.innerHTML = buttonText;
                        button.className = 'aitr-custom-btn aitr-btn-' + field;
                        button.setAttribute('data-field', field);
                        button.setAttribute('data-value', value);
                        button.style.cssText = 'margin-left:15px; padding:5px 12px; background:#4a6cf7; color:#fff; border-radius:6px; cursor:pointer; font-size:11px; font-weight:bold; border:none; transition:all 0.2s; white-space:nowrap;';
                        
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            applySingleField(field, value, this);
                        });
                        
                        valueCell.appendChild(button);
                        buttonsAdded++;
                        console.log('[AITR] Bouton ajouté pour', field);
                    }
                }
            }
        });
        
        if (buttonsAdded > 0) {
            console.log('[AITR] ' + buttonsAdded + ' bouton(s) ajouté(s) à droite');
        }
        
        return buttonsAdded;
    }
    
    // Initialisation
    function init() {
        console.log('[AITR] Initialisation...');
        
        // Essayer d'abord la méthode des boutons regroupés
        setTimeout(addButtonsColumnToRight, 500);
        setTimeout(addButtonsColumnToRight, 1000);
        setTimeout(addButtonsColumnToRight, 2000);
        
        // Fallback: boutons individuels
        setTimeout(() => addIndividualButtonsToRight(), 500);
        setTimeout(() => addIndividualButtonsToRight(), 1000);
        setTimeout(() => addIndividualButtonsToRight(), 2000);
        setTimeout(() => addIndividualButtonsToRight(), 3000);
    }
    
    // Démarrer
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    // Observer les changements DOM
    const observer = new MutationObserver(() => {
        setTimeout(addIndividualButtonsToRight, 100);
    });
    
    setTimeout(() => {
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }, 500);
    
})();
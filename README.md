# 📚 Libro-Latte
Sistema web de gestión de librería desarrollado con PHP, MVC y PDO.

## Cronograma del Proyecto
```mermaid
gantt
    title Cronograma por Fases - Libro&Latte (Completado)
    dateFormat  YYYY-MM-DD
    
    section 1. Análisis
    Requisitos y MER             :done, des, 2026-03-01, 15d
    
    section 2. Backend
    Estructura PDO y Repositorios :done, db, after des, 25d
    
    section 3. Frontend
    Header Grid y Vistas         :done, ui, after db, 20d
    
    section 4. Core
    Auth, Buscador y Reservas    :done, core, after ui, 25d
    
    section 5. Entrega
    Git, Pruebas y Ajustes       :done, dep, after core, 15d

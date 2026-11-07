# 📚 Libro-Latte
Sistema web de gestión de librería desarrollado con PHP, MVC y PDO.

## Cronograma del Proyecto
```mermaid
gantt
    title Cronograma por Fases - Libro&Latte
    dateFormat  YYYY-MM-DD
    
    section 1. Análisis y Diseño
    Requisitos y Modelo MER          :done, des, 2026-03-01, 14d
    
    section 2. Base de Datos y Backend
    Estructura PDO y Repositorios    :done, db, after des, 30d
    
    section 3. UI y Frontend
    Header CSS Grid y Vistas         :done, ui, after db, 30d
    
    section 4. Funcionalidades Core
    Auth, Buscador y Reservas        :active, core, after ui, 30d
    
    section 5. Integración y Entrega
    Git, Pruebas y Ajustes Finales   :dep, after core, 15d

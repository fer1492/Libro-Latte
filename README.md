## Cronograma del Proyecto (Gantt)

```mermaid
gantt
    title Cronograma - Libro-Latte
    dateFormat  YYYY-MM-DD
    axisFormat  %b %Y

    section Fases del Proyecto
    Análisis y diseño          :a1, 2026-09-01, 15d
    Base de datos y backend    :a2, after a1, 25d
    UI y FrontEnd              :a3, after a2, 20d
    Funcionalidades Core       :a4, after a3, 25d
    Integración y entrega      :a5, after a4, 15d

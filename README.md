## Cronograma del Proyecto (Gantt)

```mermaid
gantt
    title Cronograma - Libro-Latte
    dateFormat  YYYY-MM-DD
    axisFormat  %d/%m/%Y

    section Fases del Proyecto
    Análisis y diseño (01/09/26 - 15/09/26)       :a1, 2026-09-01, 15d
    Base de datos y backend (16/09/26 - 10/10/26) :a2, after a1, 25d
    UI y FrontEnd (11/10/26 - 30/10/26)           :a3, after a2, 20d
    Funcionalidades Core (31/10/26 - 24/11/26)    :a4, after a3, 25d
    Integración y entrega (25/11/26 - 09/12/26)   :a5, after a4, 15d

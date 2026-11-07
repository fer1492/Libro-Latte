## Cronograma del Proyecto (Libro-Latte)

### Detalle de Fases y Fechas
1. Análisis y diseño: 01/09/2026 – 09/09/2026
2. Base de datos y backend: 10/09/2026 – 29/09/2026
3. UI y FrontEnd: 30/09/2026 – 19/10/2026
4. Integración y entrega: 20/10/2026 – 28/10/2026
5. Funcionalidades Core: 29/10/2026 – 10/11/2026

```mermaid
gantt
    title Cronograma de Fases - Libro-Latte
    dateFormat  YYYY-MM-DD
    axisFormat  %b %Y

    section Desarrollo
    Análisis y diseño          :a1, 2026-09-01, 2026-09-09
    Base de datos y backend    :a2, 2026-09-10, 2026-09-29
    UI y FrontEnd              :a3, 2026-09-30, 2026-10-19
    Integración y entrega      :a5, 2026-10-20, 2026-10-28
    Funcionalidades Core       :a4, 2026-10-29, 2026-11-10
```

## Diagrama PERT - Red de Dependencias (Libro-Latte)

```mermaid
flowchart TD
    A[Análisis y diseño] --> B[Base de datos y backend]
    B --> C[UI y FrontEnd]
    C --> D[Integración y entrega]
    D --> E[Funcionalidades Core]

    style A fill:#f9f,stroke:#333,stroke-width:2px
    style B fill:#bbf,stroke:#333,stroke-width:2px
    style C fill:#bfb,stroke:#333,stroke-width:2px
    style D fill:#ff9,stroke:#333,stroke-width:2px
    style E fill:#fbb,stroke:#333,stroke-width:2px
```

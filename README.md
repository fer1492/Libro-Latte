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
    A["Análisis y diseño<br>(9 días)"] --> B["Base de datos y backend<br>(20 días)"]
    B --> C["UI y FrontEnd<br>(20 días)"]
    C --> D["Integración y entrega<br>(9 días)"]
    D --> E["Funcionalidades Core<br>(13 días)"]

    style A fill:#ff99cc,stroke:#333,stroke-width:2px,color:#000
    style B fill:#9999ff,stroke:#333,stroke-width:2px,color:#000
    style C fill:#99ff99,stroke:#333,stroke-width:2px,color:#000
    style D fill:#ffff99,stroke:#333,stroke-width:2px,color:#000
    style E fill:#ff9999,stroke:#333,stroke-width:2px,color:#000
```

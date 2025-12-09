# Justificación Técnica de Cambios en Infraestructura

## 1. Cambio de Región: De "Mexico Central" a "West US 2"

**Problema Detectado:**
Durante el aprovisionamiento inicial, la suscripción _Azure for Students_ presentó el error `RequestDisallowedByAzure` al intentar desplegar recursos en la región `mexicocentral` y `eastus`. Esto se debe a políticas de restricción de capacidad (Quota Limits) que Microsoft aplica a cuentas gratuitas en regiones de alta demanda.

**Solución Implementada:**
Se migró la infraestructura a la región **West US 2**.

- **Justificación:** Esta región mantiene disponibilidad garantizada para el tier estudiantil.
- **Impacto en Latencia:** Las pruebas preliminares muestran una latencia promedio de ~90ms desde México, lo cual cumple holgadamente con el requisito de `<300ms` establecido en la rúbrica del proyecto.

---

## 2. Escalado Vertical: De "Standard_B1s" a "Standard_B2s"

**Problema Detectado:**
El SKU `Standard_B1s` (1 vCPU, 1GB RAM) se encontraba en estado `SkuNotAvailable` (agotado) en las regiones accesibles, o bloqueado por requisitos de "Trusted Launch" incompatibles con la imagen base.

**Solución Implementada:**
Se optó por utilizar la instancia **Standard_B2s** (2 vCPUs, 4GB RAM).

**Análisis de Costos y Viabilidad (ROI):**
Aunque el costo mensual de la B2s (~$60 USD) es superior a la B1s, el proyecto tiene una duración finita de 3 días (72 horas).

- **Costo por hora B2s:** ~$0.083 USD/hora.
- **Duración del uso:** 72 horas.
- **Cálculo:** $0.083 \times 72 = \$5.97 \text{ USD}$.

**Conclusión:**
El gasto proyectado de **$5.97 USD** se mantiene dentro del presupuesto límite de **$10 USD** exigido por la rúbrica [Criterio: Pruebas/Costos]. Adicionalmente, el aumento de RAM de 1GB a 4GB asegura un rendimiento superior para el despliegue de Laravel y la base de datos MySQL, evitando cuellos de botella durante la demo en vivo.

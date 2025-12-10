# CloudEduHub Mini - Plataforma Educativa Híbrida

Repositorio oficial del proyecto **CloudEduHub Mini**. Implementación de una arquitectura híbrida (IaaS + PaaS + SaaS) desplegada en Azure Free Tier, diseñada para cumplir con los requisitos de la asignatura de Fundamentos de Cómputo en la Nube.

## 👥 Equipo y Roles

| Rol | Responsabilidades | Integrante |
| :--- | :--- | :--- |
| **Project Manager (PM)** | Gestión del backlog, repositorio y entregables | **Ian Jesus Gutierrez Diaz** |
| **Arquitecto** | Diseño de topología, diagramas y decisiones de infraestructura | **Claudio Villegas Pensado** |
| **QA / Documentación** | Pruebas de carga, manuales de usuario y auditoría | **Adan Gonzalez Luna** |
| **DevOps Lead** | CI/CD pipelines, gestión de secretos y despliegues | **Daniel Yahir Meza Navarro** |
| **Backend Dev** | Lógica de negocio (Laravel), API y Teams Sync | **Alex Ivan Zamora Contreras** **Luis Manuel Rojas Gonzalez**|
| **Frontend Dev** | Interfaz de usuario (React) y consumo de datos | **Brayan Abel Mendoza Pilar** |

## 🏗️ Estado de la Infraestructura (Sprint Día 1)

Se ha aprovisionado la capa de infraestructura base superando restricciones de disponibilidad de la suscripción *Azure for Students*:

* **Región:** `West US 2` (Migrado desde Mexico Central por políticas de restricción de Azure).
* **IaaS (Compute):** VM Ubuntu 22.04 LTS (SKU: **Standard_B2s**).
* **PaaS (Web):** Azure App Service (Runtime: PHP 8.2).
* **SaaS Integration:** Webhook preparado para Microsoft Teams.
* **Conectividad:** SSH habilitado y reglas de firewall configuradas para tráfico HTTP/HTTPS.

📅 Bitácora de Sprints

| Sprint | Objetivo | Estado | Entregables Clave |
| :--- | :--- | :--- | :--- |
| **Día 1: Infraestructura Base** | Aprovisionamiento de la capa IaaS y PaaS inicial en Azure Free Tier y validación de la conectividad básica, superando las restricciones de la suscripción. | **Finalizado** | <ul><li>Migración y aprovisionamiento de recursos en la **Región West US 2**.</li><li>**VM Ubuntu 22.04 LTS (IaaS)** configurada y accesible vía SSH.</li><li>**Azure App Service (PaaS)** con Runtime PHP 8.2 configurado.</li><li>Reglas de firewall para tráfico **HTTP/HTTPS** aplicadas.</li><li>**Webhook de Microsoft Teams** preparado para futuras integraciones SaaS.</li></ul> |

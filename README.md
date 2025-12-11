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









| Sprint | Objetivo | Estado | Entregables Clave |
| :--- | :--- | :--- | :--- |
| **Día 2: Desarrollo de la Interfaz (Frontend)** | Construcción de la interfaz funcional basada en React + Vite, consumiendo el backend existente mediante API REST. Se garantiza compatibilidad con la arquitectura planeada y se sientan las bases visuales para futuras integraciones con Teams, autenticación y métricas. | **Finalizado** | <ul><li>Estructura completa del proyecto **React + Vite**, optimizada para despliegue en Azure Static Web Apps o App Service.</li><li>Implementación del módulo **Dashboard de Tareas**, totalmente funcional.</li><li>Integración directa con el backend vía **Axios**, permitiendo CRUD completo:</li><ul><li>GET /tasks</li><li>POST /tasks</li><li>PUT /tasks/{id}</li><li>DELETE /tasks/{id}</li></ul><li>Diseño visual responsivo con **TailwindCSS**.</li><li>Archivo **.env** para gestión de variables de entorno y conexión con backend.</li><li>Estructura modular en carpetas: `pages/`, `services/`, `styles/` y `components` (preparado para escalar).</li><li>Documentación técnica del frontend incluida en el **README.md**.</li></ul> |

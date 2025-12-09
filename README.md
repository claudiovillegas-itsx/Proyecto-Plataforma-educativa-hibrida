# CloudEduHub Mini - Plataforma Educativa Híbrida

Repositorio oficial para el proyecto "CloudEduHub Mini". Implementación de una arquitectura educativa híbrida (IaaS + PaaS + SaaS) desplegada en Azure Free Tier, cubriendo el temario de Fundamentos de Cómputo en la Nube.

## 👥 Equipo y Roles

| Rol | Responsabilidades | Integrante |
| :--- | :--- | :--- |
| **Project Manager (PM)** | Coordinación, entregables, repo y backlog | Ian Jesus Gutierrez Diaz |
| **Arquitecto** | Diseño de arquitectura, diagramas, decisiones IaC | Claudio Villegas Pensado |
| **DevOps Lead** | IaC (ARM/Bicep), despliegue, pipeline CI/CD | *[Nombre Apellido]* |
| **Backend Dev** | APIs, integración con Teams/Graph, lógica de clases | *[Nombre Apellido]* |
| **Frontend Dev** | Interfaz React, integración con App Service | *[Nombre Apellido]* |
| **QA / Documentación** | Pruebas básicas, documentación y demo | Adan Gonzalez Luna |

## 🏗️ Estado de la Infraestructura (Día 1)

Debido a restricciones de stock en las regiones estándar para cuentas de estudiantes, se realizaron los siguientes ajustes técnicos para garantizar la operatividad y el presupuesto:

* **Región:** `West US 2` (Seleccionada por disponibilidad frente a Mexico Central).
* **Recurso IaaS:** VM Ubuntu 22.04 LTS (Tamaño **Standard_B2s** optimizado para 3 días de uso).
* **Recurso PaaS:** Azure App Service (PHP 8.2).
* **Modelo Híbrido:** Sincronización preparada entre Azure VM y entorno local.

## 📅 Cronograma de Sprints (3 Días)

| Día | Objetivo | Actividades Clave | Entregable |
| :--- | :--- | :--- | :--- |
| **Día 1** | **Fundamentación** | Planeación de arquitectura, Setup de Infraestructura (IaC), Repo Inicial. | Repo GitHub + Diagrama Arquitectura + VM/App Service provisionados. |
| **Día 2** | **Ejecución** | Despliegue Backend/Frontend, Integración Teams (SaaS), Pipeline CI/CD. | App funcional (Login + Tasks) + Pruebas de carga (<300ms). |
| **Día 3** | **Evaluación** | Análisis de Costos/ROI, Auditoría de Seguridad, Documentación Final. | Repo público + Video Demo + Informe Técnico + URL Pública. |

## 🤖 Ética y Transparencia: Prompts de IA Utilizados
*Cumplimiento del requisito de transparencia académica.*

### 1. Arquitectura y Diseño
> "Azure Free Tier hybrid education platform 2025: B1s VM (Mexico Central), App Service PHP, Teams API, VirtualBox private sync. Draw.io diagram + ARM templates."

### 2. Infraestructura (Corrección por disponibilidad)
> "az group create --name CloudEduHub_RG --location westus2"
> "az vm create --resource-group CloudEduHub_RG --name VM-EduHub-B1s --image Ubuntu2204 --size Standard_B2s --admin-username azureuser --generate-ssh-keys --location westus2"

### 3. Desarrollo (Pendiente Día 2)
> "Laravel edu app: auth + tasks CRUD multitenant"
> "React dashboard: tasks + metrics Azure integration"

# Student Registration Application with Kubernetes & GitLab CI/CD

## Project Overview

This project demonstrates a production-style DevOps workflow for deploying a Student Registration Application using Docker, Kubernetes, and GitLab CI/CD.

## Technologies Used

- Docker
- Kubernetes (kubeadm)
- GitLab CI/CD
- GitLab Runner (Shell Executor)
- Docker Hub
- PHP
- MySQL
- AWS EC2
- Persistent Volume (PV)
- Persistent Volume Claim (PVC)

## Project Architecture

Developer
↓
Git Push
↓
GitLab Repository
↓
GitLab Runner
↓
Docker Build
↓
Docker Hub
↓
Kubernetes Deployment
↓
Student Application
↓
MySQL Database
↓
PV + PVC

## Features

- Student Registration
- MySQL Database
- Persistent Storage using PV & PVC
- Dockerized Application
- Kubernetes Deployment
- Automated CI/CD Pipeline
- Rolling Update Deployment

## Kubernetes Resources

- Namespace
- Deployment
- Service
- Persistent Volume
- Persistent Volume Claim

## CI/CD Pipeline

The GitLab pipeline performs:

1. Build Docker Image
2. Push Image to Docker Hub
3. Deploy Latest Image to Kubernetes
4. Verify Rolling Update

## Useful Commands

```bash
kubectl get pods -n student-ns
kubectl get svc -n student-ns
kubectl get deployments -n student-ns
kubectl rollout status deployment/student-app -n student-ns
```

## Author

Vishal Pawar
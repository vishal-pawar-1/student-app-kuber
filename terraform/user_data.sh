#!/bin/bash
set -e

echo "===== Updating system ====="
apt update -y

echo "===== Installing required packages ====="
apt install -y docker.io curl ca-certificates

echo "===== Starting Docker ====="
systemctl enable docker
systemctl start docker

usermod -aG docker ubuntu

echo "===== Installing Kind ====="
curl -Lo /tmp/kind https://kind.sigs.k8s.io/dl/latest/kind-linux-amd64
chmod +x /tmp/kind
mv /tmp/kind /usr/local/bin/kind

echo "===== Installing kubectl ====="
curl -LO "https://dl.k8s.io/release/$(curl -L -s https://dl.k8s.io/release/stable.txt)/bin/linux/amd64/kubectl"
chmod +x kubectl
mv kubectl /usr/local/bin/kubectl

echo "===== Installing GitLab Runner ====="

curl -L https://packages.gitlab.com/install/repositories/runner/gitlab-runner/script.deb.sh | bash

apt install -y gitlab-runner

echo "===== Adding GitLab Runner to Docker group ====="

usermod -aG docker gitlab-runner


echo "===== Restarting Docker ====="

systemctl restart docker

echo "===== Starting GitLab Runner ====="

systemctl enable gitlab-runner
systemctl restart gitlab-runner

echo "===== Verifying Installation ====="

docker --version
kind --version
kubectl version --client
gitlab-runner --version


echo "===== Registering GitLab Runner ====="


gitlab-runner register \
  --non-interactive \
  --url "https://gitlab.com/" \
  --token "${gitlab_runner_token}" \
  --executor "shell" \
  --description "student-app-runner" \
  --tag-list "student-app" \
  --run-untagged="false"

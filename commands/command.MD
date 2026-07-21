# Kubernetes Cluster Setup Commands (Ubuntu)

## Step 1 - Disable Swap

```bash
sudo swapoff -a
```

---

## Step 2 - Load Kernel Modules

```bash
cat <<EOF | sudo tee /etc/modules-load.d/k8s.conf
overlay
br_netfilter
EOF

sudo modprobe overlay
sudo modprobe br_netfilter
```

Verify

```bash
lsmod | grep overlay
lsmod | grep br_netfilter
```

---

## Step 3 - Configure Sysctl

```bash
cat <<EOF | sudo tee /etc/sysctl.d/k8s.conf
net.bridge.bridge-nf-call-iptables=1
net.bridge.bridge-nf-call-ip6tables=1
net.ipv4.ip_forward=1
EOF

sudo sysctl --system
```

Verify

```bash
sysctl net.ipv4.ip_forward
```

---

## Step 4 - Install Containerd

```bash
sudo apt-get update

sudo apt-get install -y ca-certificates curl

sudo install -m 0755 -d /etc/apt/keyrings

sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc

sudo chmod a+r /etc/apt/keyrings/docker.asc

echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update

sudo apt-get install -y containerd.io
```

---

## Step 5 - Configure Containerd

```bash
containerd config default | sed \
-e 's/SystemdCgroup = false/SystemdCgroup = true/' \
-e 's/sandbox_image = "registry.k8s.io\/pause:3.6"/sandbox_image = "registry.k8s.io\/pause:3.9"/' \
| sudo tee /etc/containerd/config.toml
```

Restart

```bash
sudo systemctl restart containerd

sudo systemctl enable containerd

sudo systemctl status containerd
```

---

## Step 6 - Install Kubernetes

```bash
sudo apt-get update

sudo apt-get install -y apt-transport-https ca-certificates curl gpg

curl -fsSL https://pkgs.k8s.io/core:/stable:/v1.29/deb/Release.key | sudo gpg --dearmor -o /etc/apt/keyrings/kubernetes-apt-keyring.gpg

echo 'deb [signed-by=/etc/apt/keyrings/kubernetes-apt-keyring.gpg] https://pkgs.k8s.io/core:/stable:/v1.29/deb/ /' | sudo tee /etc/apt/sources.list.d/kubernetes.list

sudo apt-get update

sudo apt-get install -y kubelet kubeadm kubectl

sudo apt-mark hold kubelet kubeadm kubectl
```

Verify

```bash
kubeadm version

kubectl version --client

kubelet --version
```

---

# Control Plane Commands

## Step 7 - Initialize Cluster

```bash
sudo kubeadm init --pod-network-cidr=192.168.0.0/16
```

---

## Step 8 - Configure kubectl

```bash
mkdir -p $HOME/.kube

sudo cp -i /etc/kubernetes/admin.conf $HOME/.kube/config

sudo chown $(id -u):$(id -g) $HOME/.kube/config
```

Verify

```bash
kubectl get nodes
```

---

## Step 9 - Install Calico

```bash
kubectl apply -f https://raw.githubusercontent.com/projectcalico/calico/v3.26.0/manifests/calico.yaml
```

Verify

```bash
kubectl get pods -n kube-system
```

---

## Step 10 - Generate Join Command

```bash
kubeadm token create --print-join-command
```

Example

```bash
sudo kubeadm join 172.31.3.4:6443 \
--token abcdef.1234567890abcdef \
--discovery-token-ca-cert-hash sha256:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx \
--cri-socket unix:///run/containerd/containerd.sock
```

---

# Worker Node Commands

## Step 11 - Reset (Only if Required)

```bash
sudo kubeadm reset -f
```

---

## Step 12 - Join Cluster

```bash
sudo kubeadm join <CONTROL-PLANE-IP>:6443 \
--token <TOKEN> \
--discovery-token-ca-cert-hash sha256:<HASH> \
--cri-socket unix:///run/containerd/containerd.sock \
--v=5
```

---

# Verify Cluster

```bash
kubectl get nodes

kubectl get pods -A

kubectl cluster-info
```

---

# Remove Taint (Single Node Only)

```bash
kubectl taint nodes --all node-role.kubernetes.io/control-plane-
```

---

# Create Namespace

```bash
kubectl create namespace student-ns

kubectl get ns
```

---

# Label Worker Node

```bash
kubectl label node <worker-node-name> database=mysql

kubectl get nodes --show-labels
```
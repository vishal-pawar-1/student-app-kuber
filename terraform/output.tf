output "ec2_dns" {
    description = "ec2-public-dns"
    value = aws_instance.student_ec2.public_dns
}

output "ec2-public-ip" {
    description = "ec2-publice-ip"
    value = aws_instance.student_ec2.public_ip
}
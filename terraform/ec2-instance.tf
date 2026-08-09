resource "aws_instance" "student_ec2" {
  ami           = "ami-01a00762f46d584a1"
  instance_type = "t3.large"

  vpc_security_group_ids = [
    aws_security_group.student_sg.id
  ]

  key_name = aws_key_pair.student-key.key_name

  root_block_device {
    volume_size = 20
    volume_type = "gp3"
  }

  user_data = templatefile("${path.module}/user_data.sh", {
    gitlab_runner_token = var.gitlab_runner_token
  })

  tags = {
    Name = "student-server1.0"
  }
}
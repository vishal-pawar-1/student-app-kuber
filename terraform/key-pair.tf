resource "aws_key_pair" "student-key" {
    key_name = "student-server-key"
    public_key = file("student-key.pub")
  
}
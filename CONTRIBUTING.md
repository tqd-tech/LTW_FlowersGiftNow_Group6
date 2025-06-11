# 🤝 Quy tắc dự án: Interior Design Website

Chào mừng bạn đến với dự án nhóm 6 – website thiết kế nội thất. Vui lòng đọc kỹ hướng dẫn sau để làm việc nhóm hiệu quả, tránh xung đột code.

---

## 👥 Phân công thành viên

| Tên                 | Vai trò       | Nhiệm vụ                       |
|---------------------|----------------|--------------------------------|
| Trần Quang Dũng     | Leader         | Phân chia công việc, merge code |
| Nguyễn Trường Lâm        | FE Developer   | Giao diện trang chủ, login     |
| Nguyễn Lê Tuấn          | FE Developer   | Chi tiết sản phẩm, đơn hàng |
| Hoàng Nguyên Soái           | BE Developer   | API người dùng, đăng nhập      |
| Vũ Minh Quang        | BE Developer   | API sản phẩm, đơn hàng   |

---

## 🌿 Quy tắc làm việc với Git

## 🌳 Quy tắc đặt tên Git branch
Tên branch nên rõ ràng, theo cấu trúc:
📌 **Ví dụ:**
- `frontend/login-page`
- `frontend/product-detail`
- `backend/api-auth`
- `backend/api-products`
> **Cấu trúc:** Loại công việc: tính năng

## ✍️ Quy tắc đặt tên commit
Commit message nên ngắn gọn. Format chuẩn:
📌 **Ví dụ:**
- `[Login] Thêm UI đăng nhập`
- `[API] Tạo endpoint đăng ký`
- `[Layout] Fix responsive trang chủ`

> ❗ Không dùng commit kiểu “update code”, “fix bug”, “làm tiếp”

## 🔑 Các lệnh cần thiết
Lệnh dùng trong suốt quá trình làm
📌**Ví dụ:**
- 1️⃣**Dành cho lần đầu tiên(lựa chọn thư mục phù hợp)**:
  - `git clone https[:]//github[.]com/tqd-tech/LTW_InteriorDesign_Group6.git (xoá ngoặc vuông)`
> 💡Hoặc tải trực tiếp file ZIP về máy
- ✅**Dành cho những lần tiếp theo**:
  1. Cập nhật phiên bản github mới nhất trước khi làm (tiếp) đối với thành viên:
     - `git checkout dev`
     - `git pull origin dev`
  2. Tạo nhánh mới để làm theo tính năng    
     - `git checkout -b tên-nhánh(đặt tên đúng quy tắc ở trên)`
  3. Sau khi làm xong, lưu lại thay đổi
     - `git add .`
     - `git commit -m 'tên commit'(đặt tên commit theo đúng quy tắc) `
  4. Đẩy lên nhánh của bạn
     - `git push origin tên-nhánh`
  5. Đợi leader review và merge vào dev
  6. Sau khi đc merge dev, muốn làm tiếp phải cập nhật lại dev (vì các thành viên khác sẽ thay đổi code liên tục) quay lại bước đầu và tiếp tục.
    

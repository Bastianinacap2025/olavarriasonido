// src/pages/api/contacto.ts
import type { APIRoute } from "astro";
import nodemailer from "nodemailer";

export const POST: APIRoute = async ({ request }) => {
  const data = await request.formData();
  const nombre = data.get("nombre")?.toString();
  const email = data.get("email")?.toString();
  const telefono = data.get("telefono")?.toString();
  const mensaje = data.get("mensaje")?.toString();

  if (!nombre || !email || !mensaje) {
    return new Response("Faltan datos obligatorios", { status: 400 });
  }

  try {
    const transporter = nodemailer.createTransport({
      service: "Gmail",
      auth: {
        user: "import.meta.env.MAIL_USER",        // <-- reemplaza con tu correo
        pass: "import.meta.env.MAIL_PASS",         // <-- usa una App Password si es Gmail
      },
    });

    await transporter.sendMail({
      from: `"Olavarría Sonido" <TUCORREO@gmail.com>`,
      to: "TUCORREO@gmail.com",
      subject: "Nuevo mensaje de contacto",
      text: `
    Nombre: ${nombre}
    Email: ${email}
    Teléfono: ${telefono}
    Mensaje:
    ${mensaje}
      `,
    });

    return new Response("Mensaje enviado con éxito", { status: 200 });
  } catch (err) {
    console.error("Error al enviar correo:", err);
    return new Response("Error al enviar el mensaje", { status: 500 });
  }
};
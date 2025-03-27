import { PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
// import { AuthenticatedLayoutProps } from '@/Layouts/AuthenticatedLayout';

export default function Welcome({
  auth,
  laravelVersion,
  phpVersion,
}: PageProps<{ auth: { user?: { name: string}}; laravelVersion: string; phpVersion: string }>) {
  const handleImageError = () => {
    document
      .getElementById('screenshot-container')
      ?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document
      .getElementById('docs-card-content')
      ?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
  };

  return (
    <AuthenticatedLayout>
      <Head title="Welcome" />
      <div
  className="hero h-[500px]"
  style={{
    backgroundImage: "url(https://img.daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.webp)",
  }}>
  <div className="hero-overlay"></div>
  <div className="hero-content text-neutral-content text-center">
    <div className="max-w-md">
      <h1 className="mb-5 text-5xl font-bold">Hello there</h1>
      <p className="mb-5">
        Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
        quasi. In deleniti eaque aut repudiandae et a id nisi.
      </p>
      <button className="btn btn-primary">Get Started</button>
    </div>
  </div>
</div>
    </AuthenticatedLayout>
  );
}

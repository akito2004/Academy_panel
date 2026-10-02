<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-post-outline title_icon"></i> Blog
                    <a href="<?php echo site_url('admin/blog_form/add'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle">
                        <i class="mdi mdi-plus"></i> Nueva publicación
                    </a>
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered mb-0">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Estado</th>
                                <th>Creada</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($posts)): ?>
                                <tr><td colspan="5" class="text-center">Todavía no hay publicaciones.</td></tr>
                            <?php else: ?>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($post['imagen_url'])): ?>
                                                <img src="<?php echo html_escape($post['imagen_url']); ?>" alt="" style="width: 72px; height: 48px; object-fit: cover; border-radius: 6px;">
                                            <?php else: ?>
                                                <span class="text-muted">Sin imagen</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo html_escape($post['titulo']); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $post['estado'] === 'publicado' ? 'success' : ($post['estado'] === 'archivado' ? 'secondary' : 'warning'); ?>">
                                                <?php echo html_escape(ucfirst($post['estado'])); ?>
                                            </span>
                                        </td>
                                        <td><?php echo html_escape($post['fecha_creacion']); ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo site_url('admin/blog_form/edit/' . (int) $post['id']); ?>" class="btn btn-outline-info btn-sm">
                                                <i class="mdi mdi-pencil"></i> Editar
                                            </a>
                                            <a href="#" class="btn btn-outline-danger btn-sm" onclick="confirm_modal('<?php echo site_url('admin/blog/delete/' . (int) $post['id']); ?>'); return false;">
                                                <i class="mdi mdi-delete"></i> Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

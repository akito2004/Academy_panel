<?php $post = is_array($post) ? $post : array(); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-post-outline title_icon"></i> <?php echo html_escape($page_title); ?>
                    <a href="<?php echo site_url('admin/blog'); ?>" class="btn btn-outline-secondary btn-rounded alignToTitle">
                        <i class="mdi mdi-keyboard-backspace"></i> Volver al blog
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
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="header-title my-1">Formulario de publicación</h4>
                    </div>
                </div>

                <form class="required-form" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                        <label for="titulo" class="col-md-3 col-form-label">Título <span class="required">*</span></label>
                        <div class="col-md-9">
                            <input id="titulo" name="titulo" class="form-control" required maxlength="250" value="<?php echo html_escape($post['titulo'] ?? ''); ?>" placeholder="Escribe el título de la publicación">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="summernote-basic" class="col-md-3 col-form-label">Contenido</label>
                        <div class="col-md-9">
                            <textarea id="summernote-basic" name="contenido" class="form-control"><?php echo html_escape($post['contenido'] ?? ''); ?></textarea>
                            <small class="form-text text-muted">Usa la barra para aplicar formato, crear listas, insertar enlaces, imágenes y código.</small>
                        </div>

                    <div class="form-group row mb-3">
                        <label for="imagen" class="col-md-3 col-form-label">Imagen de portada</label>
                        <div class="col-md-9">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-outline-primary" id="buscar-imagen">
                                    <i class="mdi mdi-image-search"></i> Buscar imagen
                                </button>
                                <span id="nombre-imagen" class="ml-2 text-muted">Ninguna imagen seleccionada</span>
                            </div>
                            <input id="imagen" name="imagen" type="file" accept="image/jpeg,image/png,image/gif,image/webp" style="display: none;">
                            <small class="form-text text-muted">JPG, PNG, GIF o WEBP. Tamaño máximo: 5 MB.</small>
                            <?php if (!empty($post['imagen_url'])): ?>
                                <div class="mt-2">
                                    <img src="<?php echo html_escape($post['imagen_url']); ?>" alt="Imagen actual" style="max-width: 260px; max-height: 150px; object-fit: cover;">
                                    <input type="hidden" name="imagen_url" value="<?php echo html_escape($post['imagen_url']); ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="resumen" class="col-md-3 col-form-label">Resumen</label>
                        <div class="col-md-9">
                            <textarea id="resumen" name="resumen" class="form-control" rows="3" maxlength="500" placeholder="Texto breve que aparecerá en la portada"><?php echo html_escape($post['resumen'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="autor_nombre" class="col-md-3 col-form-label">Autor visible</label>
                        <div class="col-md-9">
                            <input id="autor_nombre" name="autor_nombre" class="form-control" maxlength="150" value="<?php echo html_escape($post['autor_nombre'] ?? 'AiaAcademy'); ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="tiempo_lectura" class="col-md-3 col-form-label">Tiempo de lectura</label>
                        <div class="col-md-9">
                            <input id="tiempo_lectura" name="tiempo_lectura" class="form-control" maxlength="50" value="<?php echo html_escape($post['tiempo_lectura'] ?? '5 min lectura'); ?>" placeholder="Ejemplo: 8 min lectura">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="enlaces_relacionados" class="col-md-3 col-form-label">Enlaces relacionados</label>
                        <div class="col-md-9">
                            <textarea id="enlaces_relacionados" name="enlaces_relacionados" class="form-control" rows="4" placeholder="Un enlace por línea. Ejemplo:&#10;Documentación|https://ejemplo.com"><?php echo html_escape($post['enlaces_relacionados'] ?? ''); ?></textarea>
                            <small class="form-text text-muted">Usa el formato: texto del enlace|URL, uno por línea.</small>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="estado" class="col-md-3 col-form-label">Estado</label>
                        <div class="col-md-9">
                            <select id="estado" name="estado" class="form-control">
                                <?php $current_status = $post['estado'] ?? 'borrador'; ?>
                                <option value="borrador" <?php echo $current_status === 'borrador' ? 'selected' : ''; ?>>Borrador</option>
                                <option value="publicado" <?php echo $current_status === 'publicado' ? 'selected' : ''; ?>>Publicado</option>
                                <option value="archivado" <?php echo $current_status === 'archivado' ? 'selected' : ''; ?>>Archivado</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save-outline"></i> Guardar publicación
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <script>
                $('#buscar-imagen').on('click', function () {
                    $('#imagen').trigger('click');
                });
                $('#imagen').on('change', function () {
                    var fileName = this.files.length ? this.files[0].name : 'Ninguna imagen seleccionada';
                    $('#nombre-imagen').text(fileName);
                });
            </script>
        </div>
    </div>
</div>

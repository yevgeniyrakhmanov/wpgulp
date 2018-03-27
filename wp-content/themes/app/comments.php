<div id="comments" class="comments small-text mt-5">
	<p class="lead page-header">Комментарии <span class="badge badge-secondary"><?php echo get_comments_number(); ?></span></p>
	<?php if (have_comments()) : // если комменты есть ?>
	<ul class="comment-list list-unstyled media">
		<?php
			$args = array(
				'walker' => new clean_comments_constructor,
			);
			wp_list_comments($args);
		?>
	</ul>
	<?php if (get_comment_pages_count() > 1 && get_option( 'page_comments')) : ?>
	<?php
		$args = array(
			'prev_text' => '«',
			'next_text' => '»'
		); 
		paginate_comments_links($args);
	?>
	<?php endif; ?>
	<?php endif; ?>
	<?php if (comments_open()) {
		$fields = array(
		'author' => '
			<div class="form-group comment-form-author">
				<label for="author">' . __( 'Name' ) . ($req ? '<span class="required">*</span>' : '') . '</label>
				<input type="text" id="author" name="author" class="form-control author" value="' . esc_attr($commenter['comment_author']) . '" placeholder="Иван Петров" pattern="[A-Za-zА-Яа-я]{3,}" maxlength="30" autocomplete="on" tabindex="1" required' . $aria_req . '>
			</div>',
		'email' => '
			<div class="form-group comment-form-email">
				<label for="email">' . __( 'Email') . ($req ? '<span class="required">*</span>' : '') . '</label>
				<input type="email" id="email" name="email" class="form-control email" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="example@example.com" maxlength="30" autocomplete="on" tabindex="2" required' . $aria_req . '>
			</div>'
		);
		$args = array(
			'fields' => apply_filters('comment_form_default_fields', $fields),
			'comment_field' => '
				<div class="form-group comment-form-comment">
					<label for="comment">' . _x( 'Comment', 'noun' ) . '*</label>
					<textarea id="comment" name="comment" class="form-control comment-form" cols="45" rows="8" aria-required="true" placeholder="Текст сообщения..."></textarea>
				</div>',
			'must_log_in' => '<p class="must-log-in">Вы должны быть зарегистрированы! '.wp_login_url(apply_filters('the_permalink',get_permalink())).'</p>',
			'logged_in_as' => '<p class="logged-in-as">'.sprintf(__( 'Вы вошли как <a href="%1$s">%2$s</a>. <a href="%3$s">Выйти?</a>'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink',get_permalink()))).'</p>',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'id_form' => 'commentform',
			'id_submit' => 'submit',
			'title_reply' => 'Комментировать',
			'title_reply_to' => 'Ответить %s',
			'cancel_reply_link' => 'Отменить ответ',
			'label_submit' => 'Опубликовать'
		);
		ob_start();
	    comment_form($args);
	    $what_changes = array(
	    		'<small>' => '',
	    		'</small>' => '',
	    		'<h3 id="reply-title" class="comment-reply-title">' => '<div id="reply-title" class="lead page-header">',
	    		'</h3>' => '</div>',
	    		'class="submit"' => 'class="submit btn btn-primary"'
	    	);
	    $new_form = str_replace(array_keys($what_changes), array_values($what_changes), ob_get_contents());
	    ob_end_clean();
	    echo $new_form;
	} ?>
</div>